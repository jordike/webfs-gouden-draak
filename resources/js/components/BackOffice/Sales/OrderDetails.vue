<script lang="ts" setup>
    import axios from 'axios';
    import { ref } from 'vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    const props = defineProps<{ order: any }>();
    const emit = defineEmits(['splitSaved']);

    const showSplit = ref(false);
    const partsCount = ref(1);
    const maxParts = 8;
    const parts = ref(Array.from({ length: maxParts }, () => []));

    function setPartsCount(count: number) {
        partsCount.value = count;

        while (parts.value.length < count) parts.value.push([]);
        while (parts.value.length > count) parts.value.pop();
    }

    function assignToPart(partIdx: number, orderItemId: number, amount: number) {
        const totalOther = parts.value.reduce((sum, p, idx) => {
            if (idx === partIdx) return sum;

            const found: any = p.find((x: any) => x.orderItemId === orderItemId);

            return sum + (found ? found.amount : 0);
        }, 0);

        const item = props.order.filteredItems.find((i: any) => i.id === orderItemId);
        const max = item ? item.amount - totalOther : 0;

        amount = Math.max(0, Math.min(amount, max));

        const part: any = parts.value[partIdx];
        const existing: any = part.find((x: any) => x.orderItemId === orderItemId);

        if (existing) {
            existing.amount = amount;
        } else {
            part.push({ orderItemId, amount });
        }

        parts.value = [...parts.value];
    }

    async function storeBillParts() {
        await axios.post(`/backoffice/orders/${props.order.id}/parts`, { count: partsCount.value });
        const assignments = parts.value.slice(0, partsCount.value).flatMap((part, idx) =>
            part
                .filter((x: any) => x.amount > 0)
                .map((x: any) => ({
                    order_item_id: x.orderItemId,
                    order_part_id: idx + 1,
                    amount: x.amount,
                })),
        );

        await axios.post(`/backoffice/orders/${props.order.id}/assign-items`, { assignments });

        emit('splitSaved');
        alert(t('backoffice.order_details.save_split') + '!');
    }
</script>

<template>
    <div class="rounded-b-lg border-t border-indigo-200 p-4">
        <div class="mb-4 flex justify-end">
            <button class="rounded bg-indigo-600 px-4 py-2 font-semibold text-white shadow hover:bg-indigo-700" @click="showSplit = !showSplit">
                {{ showSplit ? t('backoffice.order_details.cancel_split') : t('backoffice.order_details.split_bill') }}
            </button>
        </div>

        <div v-if="showSplit">
            <div class="mb-4 flex items-center gap-2">
                <label for="partsCount" class="font-semibold">{{ t('backoffice.order_details.number_of_parts') }}</label>
                <input
                    id="partsCount"
                    type="number"
                    v-model="partsCount"
                    min="1"
                    :max="maxParts"
                    @change="setPartsCount(partsCount)"
                    class="w-16 rounded border border-gray-300 px-2 py-1 text-center focus:ring-2 focus:ring-green-200 focus:outline-none"
                />
            </div>

            <div class="mb-4 grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="(part, idx) in parts.slice(0, partsCount)"
                    :key="idx"
                    class="rounded-lg border border-indigo-200 bg-indigo-50 p-2 shadow-sm"
                >
                    <h3 class="mb-1 text-base font-bold text-indigo-800">{{ t('backoffice.order_details.part', { number: idx + 1 }) }}</h3>

                    <div class="space-y-1">
                        <div v-for="item in order.filteredItems" :key="item.id" class="flex items-center gap-2">
                            <label :for="`deel-${idx}-item-${item.id}`" class="flex-1 truncate"
                                >{{ item.menu_item?.name ?? item.menu_item_id }}
                                <span class="text-xs text-gray-500">({{ t('backoffice.order_details.max', { amount: item.amount }) }})</span></label
                            >
                            <input
                                :id="`deel-${idx}-item-${item.id}`"
                                type="number"
                                :max="item.amount"
                                min="0"
                                :value="(part.find((x: any) => x.orderItemId === item.id) as any)?.amount || 0"
                                @input="assignToPart(idx, item.id, +($event.target as any).value)"
                                class="w-14 rounded border border-gray-300 px-1 py-0.5 text-center text-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 flex justify-end">
                <button class="rounded bg-indigo-600 px-4 py-2 font-semibold text-white shadow hover:bg-indigo-700" @click="storeBillParts">
                    {{ t('backoffice.order_details.save_split') }}
                </button>
            </div>
        </div>

        <div v-if="!showSplit">
            <table class="mb-2 w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-2 py-1 text-left">{{ t('backoffice.orders.dish_name') }}</th>
                        <th class="px-2 py-1 text-left">{{ t('backoffice.menu.price') }}</th>
                        <th class="px-2 py-1 text-left">{{ t('backoffice.orders.increase').replace('Verhoog aantal', 'Aantal') }}</th>
                        <th class="px-2 py-1 text-left">
                            {{
                                t('backoffice.orders.comment_placeholder').replace(
                                    'Opmerking toevoegen...',
                                    t('backoffice.order_details.no_comments'),
                                )
                            }}
                        </th>
                        <th class="px-2 py-1 text-left">{{ t('backoffice.order_details.subtotal') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in order.filteredItems" :key="item.id">
                        <td class="px-2 py-1" v-html="item.menu_item?.name ?? item.menu_item_id"></td>
                        <td class="px-2 py-1">€ {{ item.menu_item?.price ?? 0 }}</td>
                        <td class="px-2 py-1">{{ item.amount }}</td>
                        <td class="px-2 py-1" v-html="item.comment || t('backoffice.order_details.no_comments')"></td>
                        <td class="px-2 py-1">€ {{ ((item.menu_item?.price ?? 0) * item.amount).toFixed(2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 flex flex-wrap justify-end gap-6 rounded-lg bg-gray-200 p-4 text-base font-medium text-blue-900">
                <div class="flex items-center gap-2">
                    <span class="min-w-[140px]">{{ t('backoffice.sales.total_incl_vat') }}</span>
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
                    <span class="min-w-[120px]">{{ t('backoffice.sales.total_vat') }}</span>
                    <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                        €
                        {{
                            (
                                order.filteredItems.reduce((sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0) * 0.21
                            ).toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                        }}
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="min-w-[140px]">{{ t('backoffice.sales.total_excl_vat') }}</span>
                    <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm">
                        €
                        {{
                            (
                                order.filteredItems.reduce((sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0) / 1.21
                            ).toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                        }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
