<script lang="ts" setup>
    defineProps<{
        order: any;
    }>();
</script>

<template>
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

        <div class="mt-4 flex flex-wrap justify-end gap-6 rounded-lg bg-gray-200 p-4 text-base font-medium text-blue-900">
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
                            order.filteredItems.reduce((sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0) * 0.21
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
                            order.filteredItems.reduce((sum: number, item: any) => sum + (item.menu_item?.price ?? 0) * item.amount, 0) / 1.21
                        ).toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }}
                </span>
            </div>
        </div>
    </div>
</template>
