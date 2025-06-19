<script lang="ts" setup>
    import OrderFilters from '@/components/BackOffice/Sales/OrderFilters.vue';
    import OrderTable from '@/components/BackOffice/Sales/OrderTable.vue';
    import OrderTotals from '@/components/BackOffice/Sales/OrderTotals.vue';
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { usePage } from '@inertiajs/vue3';
    import { computed, reactive, ref, watch } from 'vue';

    const orders = computed(() => usePage().props.orders as any[]);

    const filterText = ref('');
    const filterStartDate = ref('');
    const filterEndDate = ref('');

    const collapsedOrders = reactive<{ [key: number]: boolean }>({});

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

                const matchesText =
                    filterText.value === '' ||
                    order.id.toString().includes(filterText.value) ||
                    order.items.some((item: any) => (item.menu_item?.name ?? '').toLowerCase().includes(filterText.value.toLowerCase()));

                return matchesText && matchesStartDate && matchesEndDate;
            })
            .map((order) => {
                const filteredItems = order.items.filter((item: any) => {
                    return (
                        filterText.value === '' ||
                        order.id.toString().includes(filterText.value) ||
                        (item.menu_item?.name ?? '').toLowerCase().includes(filterText.value.toLowerCase())
                    );
                });

                return {
                    ...order,
                    filteredItems,
                };
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

    function toggleCollapse(orderId: number): void {
        collapsedOrders[orderId] = !collapsedOrders[orderId];
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white p-6 md:p-10">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h1 class="text-3xl font-extrabold tracking-tight text-blue-900">Verkoopoverzicht</h1>

                <OrderFilters v-model:filterText="filterText" v-model:filterStartDate="filterStartDate" v-model:filterEndDate="filterEndDate" />
            </div>

            <OrderTotals :totalPrice="totalPrice" :totalVAT="totalVAT" :totalExclVAT="totalExclVAT" />

            <div v-if="filteredOrders.length === 0" class="rounded-lg bg-gray-100 p-6 text-center text-gray-800 shadow-md">
                <p class="font-medium">Geen verkopen gevonden.</p>
            </div>

            <OrderTable v-else :filteredOrders="filteredOrders" :collapsedOrders="collapsedOrders" @toggleCollapse="toggleCollapse" />
        </div>
    </BackOfficeLayout>
</template>
