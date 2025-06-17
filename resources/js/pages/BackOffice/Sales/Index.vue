<script lang="ts" setup>
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { usePage } from '@inertiajs/vue3';
    import { computed, reactive, ref, watch } from 'vue';

    const orders = computed(() => usePage().props.orders as any[]);

    const filterText = ref('');
    const filterStartDate = ref('');
    const filterEndDate = ref('');

    // Track collapsed state per order
    const collapsedOrders = reactive<{ [key: number]: boolean }>({});

    // Initialize all orders as collapsed when orders change
    watch(
        orders,
        (newOrders) => {
            for (const order of newOrders) {
                collapsedOrders[order.id] = true;
            }
        },
        { immediate: true },
    );

    const filteredOrders = computed(() => {
        return orders.value
            .filter((order) => {
                let matchesStartDate = true;
                let matchesEndDate = true;

                if (filterStartDate.value) {
                    matchesStartDate = order.date_placed && order.date_placed >= filterStartDate.value;
                }
                if (filterEndDate.value) {
                    matchesEndDate = order.date_placed && order.date_placed <= filterEndDate.value;
                }

                // Check if any item or order id matches the filterText
                const matchesText =
                    filterText.value === '' ||
                    order.id.toString().includes(filterText.value) ||
                    order.items.some((item: any) => (item.menu_item?.name ?? '').toLowerCase().includes(filterText.value.toLowerCase()));

                return matchesText && matchesStartDate && matchesEndDate;
            })
            .map((order) => {
                // Filter items by text if needed
                const filteredItems = order.items.filter((item: any) => {
                    return (
                        filterText.value === '' ||
                        order.id.toString().includes(filterText.value) ||
                        (item.menu_item?.name ?? '').toLowerCase().includes(filterText.value.toLowerCase())
                    );
                });
                return { ...order, filteredItems };
            })
            .filter((order) => order.filteredItems.length > 0);
    });

    const totalPrice = computed(() =>
        filteredOrders.value.reduce(
            (sum, order) => sum + order.filteredItems.reduce((itemSum: number, item: any) => itemSum + (item.menu_item?.price ?? 0) * item.amount, 0),
            0,
        ),
    );
    const totalVAT = computed(() => totalPrice.value * 0.21);
    const totalExclVAT = computed(() => totalPrice.value / 1.21);

    function toggleCollapse(orderId: number) {
        collapsedOrders[orderId] = !collapsedOrders[orderId];
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6 md:p-10">
            <!-- Filters and Totals (unchanged) -->
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h1 class="text-3xl font-extrabold tracking-tight text-blue-900">Verkoopoverzicht</h1>
                <div class="flex flex-wrap gap-2">
                    <input
                        v-model="filterText"
                        type="text"
                        placeholder="Bestel-ID of Gerechtnaam"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    />
                    <input
                        v-model="filterStartDate"
                        type="date"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    />
                    <input
                        v-model="filterEndDate"
                        type="date"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    />
                </div>
            </div>

            <!-- Totals Section (unchanged) -->
            <div
                class="mb-6 flex flex-col gap-2 rounded-lg bg-gradient-to-r from-green-50 to-blue-50 p-4 shadow-sm md:flex-row md:items-center md:justify-end md:gap-8"
            >
                <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
                    <span class="inline-block min-w-[160px]">Totaal (incl. btw):</span>
                    <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                        € {{ totalPrice.toFixed(2) }}
                    </span>
                </span>
                <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
                    <span class="inline-block min-w-[140px]">Totaal btw (21%):</span>
                    <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm"> € {{ totalVAT.toFixed(2) }} </span>
                </span>
                <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
                    <span class="inline-block min-w-[160px]">Totaal (excl. btw):</span>
                    <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                        € {{ totalExclVAT.toFixed(2) }}
                    </span>
                </span>
            </div>

            <div v-if="filteredOrders.length === 0" class="rounded-lg bg-yellow-100 p-6 text-center text-yellow-800 shadow-md">
                <p class="font-medium">Geen verkopen gevonden.</p>
            </div>
            <div v-else class="overflow-x-auto rounded-lg bg-white shadow-lg">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-left text-blue-900">
                            <th class="border-b px-5 py-4 font-semibold">Order</th>
                            <th class="border-b px-5 py-4 font-semibold">Datum</th>
                            <th class="border-b px-5 py-4 font-semibold">Totaal</th>
                            <th class="border-b px-5 py-4 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="order in filteredOrders" :key="order.id">
                            <tr
                                class="cursor-pointer transition-colors hover:bg-indigo-100"
                                :class="{ 'border-b-2 border-indigo-300': !collapsedOrders[order.id] }"
                                @click="toggleCollapse(order.id)"
                            >
                                <td class="border-b px-5 py-3 font-semibold">#{{ order.id }}</td>
                                <td class="border-b px-5 py-3">{{ order.date_placed }}</td>
                                <td class="border-b px-5 py-3">
                                    €
                                    {{
                                        order.filteredItems
                                            .reduce((sum: any, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0)
                                            .toFixed(2)
                                    }}
                                </td>
                                <td class="border-b px-5 py-3">
                                    <button @click.stop="toggleCollapse(order.id)" class="text-blue-600 hover:underline focus:outline-none">
                                        {{ collapsedOrders[order.id] ? 'Toon' : 'Verberg' }} details
                                    </button>
                                </td>
                            </tr>
                            <tr v-show="!collapsedOrders[order.id]">
                                <td colspan="4" class="bg-indigo-50 px-0 py-0">
                                    <div class="rounded-b-lg border-t border-indigo-200 p-4">
                                        <table class="mb-2 w-full table-auto">
                                            <thead>
                                                <tr>
                                                    <th class="px-2 py-1 text-left">Gerecht</th>
                                                    <th class="px-2 py-1 text-left">Prijs</th>
                                                    <th class="px-2 py-1 text-left">Aantal</th>
                                                    <th class="px-2 py-1 text-left">Subtotaal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in order.filteredItems" :key="item.id">
                                                    <td class="px-2 py-1" v-html="item.menu_item?.name ?? item.menu_item_id"></td>
                                                    <td class="px-2 py-1">€ {{ item.menu_item?.price ?? 0 }}</td>
                                                    <td class="px-2 py-1">{{ item.amount }}</td>
                                                    <td class="px-2 py-1">€ {{ ((item.menu_item?.price ?? 0) * item.amount).toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div
                                            class="mt-4 flex flex-wrap justify-end gap-6 rounded-lg bg-gray-200 p-4 text-base font-medium text-blue-900"
                                        >
                                            <div class="flex items-center gap-2">
                                                <span class="min-w-[140px]">Totaal (incl. btw):</span>
                                                <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                                                    €
                                                    {{
                                                        order.filteredItems
                                                            .reduce((sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0)
                                                            .toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                                    }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="min-w-[120px]">Totaal btw (21%):</span>
                                                <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                                                    €
                                                    {{
                                                        (
                                                            order.filteredItems.reduce(
                                                                (sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount,
                                                                0,
                                                            ) * 0.21
                                                        ).toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                                    }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="min-w-[140px]">Totaal (excl. btw):</span>
                                                <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                                                    €
                                                    {{
                                                        (
                                                            order.filteredItems.reduce(
                                                                (sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount,
                                                                0,
                                                            ) / 1.21
                                                        ).toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </BackOfficeLayout>
</template>
