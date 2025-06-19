<script lang="ts" setup>
    import OrderDetails from './OrderDetails.vue';

    defineProps<{
        filteredOrders: any[];
        collapsedOrders: Record<number, boolean>;
    }>();

    const emit = defineEmits(['toggleCollapse']);

    function toggleCollapse(orderId: number): void {
        emit('toggleCollapse', orderId);
    }
</script>

<template>
    <div class="overflow-x-auto rounded-lg bg-white shadow-lg">
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
                            {{ order.filteredItems.reduce((sum: any, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0).toFixed(2) }}
                        </td>
                        <td class="border-b px-5 py-3">
                            <button @click.stop="toggleCollapse(order.id)" class="text-blue-600 hover:underline focus:outline-none">
                                {{ collapsedOrders[order.id] ? 'Toon' : 'Verberg' }} details
                            </button>
                        </td>
                    </tr>

                    <tr v-show="!collapsedOrders[order.id]">
                        <td colspan="4" class="bg-indigo-50 px-0 py-0">
                            <OrderDetails :order="order" />
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>
