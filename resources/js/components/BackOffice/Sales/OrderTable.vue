<script lang="ts" setup>
    import { useI18n } from 'vue-i18n';
    import OrderDetails from './OrderDetails.vue';

    const { t } = useI18n();

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
                    <th class="border-b px-5 py-4 font-semibold">{{ t('backoffice.sales.order') }}</th>
                    <th class="border-b px-5 py-4 font-semibold">{{ t('backoffice.sales.date') }}</th>
                    <th class="border-b px-5 py-4 font-semibold">{{ t('backoffice.sales.total') }}</th>
                    <th class="border-b px-5 py-4 font-semibold" colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                <template v-for="order in filteredOrders" :key="order.id">
                    <tr class="transition-colors hover:bg-indigo-100" :class="{ 'border-b-2 border-indigo-300': !collapsedOrders[order.id] }">
                        <td class="border-b px-5 py-3 font-semibold">#{{ order.id }}</td>
                        <td class="border-b px-5 py-3">{{ order.date_placed }}</td>
                        <td class="border-b px-5 py-3">
                            €
                            {{ order.filteredItems.reduce((sum: any, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0).toFixed(2) }}
                        </td>
                        <td class="border-b px-5 py-3">
                            <button @click.stop="toggleCollapse(order.id)" class="text-blue-600 hover:underline focus:outline-none">
                                {{ collapsedOrders[order.id] ? t('backoffice.sales.show_details') : t('backoffice.sales.hide_details') }}
                            </button>
                        </td>
                        <td>
                            <a :href="`/backoffice/sales/export/${order.id}`" class="text-blue-600 hover:underline focus:outline-none">
                                {{ t('backoffice.sales.download_pdf') }}
                            </a>
                        </td>
                    </tr>

                    <tr v-show="!collapsedOrders[order.id]">
                        <td colspan="5" class="bg-indigo-50 px-0 py-0" @click.stop>
                            <OrderDetails :order="order" />
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>
