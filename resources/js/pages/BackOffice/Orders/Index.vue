<script lang="ts" setup>
    import MenuCategoryList from '@/components/BackOffice/Orders/MenuCategoryList.vue';
    import OrderList from '@/components/BackOffice/Orders/OrderList.vue';
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { computed, Ref, ref } from 'vue';

    const props = defineProps<{
        categories: Array<any>;
        csrfToken: string;
    }>();

    const filter = ref('');
    const orderItems: Ref<Array<any>> = ref([]);

    const filteredCategories = computed(() => {
        if (!filter.value.trim()) {
            return props.categories.map((category) => ({
                ...category,
                items: [...category.items].sort((a: any, b: any) => a.id - b.id),
            }));
        }

        const filterText = filter.value.toLowerCase();

        return props.categories
            .map((category) => {
                const categoryNameMatches = category.name.toLowerCase().includes(filterText);
                const filteredItems = category.items.filter(
                    (item: any) =>
                        item.name.toLowerCase().includes(filterText) ||
                        (item.description && item.description.toLowerCase().includes(filterText)) ||
                        item.id.toString().includes(filterText),
                );
                const itemsToShow = categoryNameMatches ? category.items : filteredItems;

                return {
                    ...category,
                    items: [...itemsToShow].sort((a: any, b: any) => a.id - b.id),
                };
            })
            .filter((category) => category.items.length > 0);
    });

    function addOrderItem(item: any): void {
        const existing = orderItems.value.find((o) => o.id === item.id);

        if (existing) {
            existing.amount = (existing.amount || 1) + 1;
        } else {
            orderItems.value.push({ ...item, amount: 1 });
        }
    }

    function increaseOrderItem(idx: number): void {
        const item = orderItems.value[idx];

        if (item) item.amount = (item.amount || 1) + 1;
    }

    function decreaseOrderItem(idx: number): void {
        const item = orderItems.value[idx];

        if (item) {
            item.amount = (item.amount || 1) - 1;

            if (item.amount <= 0) orderItems.value.splice(idx, 1);
        }
    }

    function removeOrderItem(idx: number): void {
        orderItems.value.splice(idx, 1);
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <div class="flex flex-col gap-10 lg:flex-row">
                <section class="flex-1">
                    <div class="sticky top-0 z-20 border-b-1 border-gray-200 bg-gray-50 pt-2 pb-4">
                        <div class="mx-auto max-w-3xl">
                            <h2 class="mb-6 text-2xl font-bold text-green-700">Menu</h2>

                            <div class="mb-4 flex items-center gap-3">
                                <div class="relative w-full">
                                    <input
                                        v-model="filter"
                                        type="text"
                                        placeholder="Zoek op naam, omschrijving, categorie of ID..."
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 pl-10 shadow-sm transition focus:border-green-500 focus:ring-2 focus:ring-green-200"
                                    />
                                    <svg
                                        class="pointer-events-none absolute top-2.5 left-3 h-5 w-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"
                                        />
                                    </svg>
                                </div>

                                <button
                                    v-if="filter"
                                    @click="filter = ''"
                                    class="ml-2 rounded-full bg-gray-200 p-2 text-gray-500 transition hover:bg-gray-300"
                                    title="Wis zoekopdracht"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mx-auto max-w-3xl py-6">
                        <div v-if="filteredCategories.length === 0" class="py-16 text-center text-lg text-gray-400">
                            <svg class="mx-auto mb-2 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12A9 9 0 113 12a9 9 0 0118 0z"
                                />
                            </svg>
                            Geen resultaten gevonden.
                        </div>

                        <MenuCategoryList :categories="filteredCategories" @add-item="addOrderItem" />
                    </div>
                </section>

                <section class="flex-1 border-l-1 border-gray-200 pl-6 lg:max-w-md">
                    <div class="sticky top-8">
                        <h2 class="mb-6 text-2xl font-bold text-green-700">Bestelling</h2>

                        <form class="flex min-h-[400px] flex-col" style="height: 500px; max-height: 70vh" method="POST" action="/backoffice/orders">
                            <input type="hidden" name="_token" :value="csrfToken" />

                            <div class="flex min-h-[200px] flex-col items-center justify-center p-6 text-gray-400" v-if="orderItems.length == 0">
                                <svg class="mb-2 h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                <span class="text-lg">Nog geen items toegevoegd.</span>
                            </div>

                            <OrderList
                                v-else
                                :orderItems="orderItems"
                                @increase="increaseOrderItem"
                                @decrease="decreaseOrderItem"
                                @remove="removeOrderItem"
                            />

                            <div class="mt-auto flex items-center justify-between rounded-b-xl bg-gray-50 px-6 py-4 shadow-inner">
                                <div class="text-lg font-semibold text-gray-700">
                                    Totaal:
                                    <span class="text-green-700">
                                        €{{ orderItems.reduce((sum, item) => sum + item.price * (item.amount || 1), 0).toFixed(2) }}
                                    </span>
                                </div>

                                <button
                                    class="rounded-lg bg-gradient-to-br from-green-500 to-green-600 px-6 py-2 font-bold text-white shadow transition hover:from-green-600 hover:to-green-700"
                                    type="submit"
                                >
                                    Betalen
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </BackOfficeLayout>
</template>
