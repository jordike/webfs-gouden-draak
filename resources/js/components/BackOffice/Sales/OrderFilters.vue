<script lang="ts" setup>
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    defineProps<{
        filterText: string;
        filterStartDate: string;
        filterEndDate: string;
    }>();

    defineEmits(['update:filterText', 'update:filterStartDate', 'update:filterEndDate']);

    const filterText = defineModel('filterText');
    const filterStartDate = defineModel('filterStartDate');
    const filterEndDate = defineModel('filterEndDate');

    function clearFilters(): void {
        filterText.value = '';
        filterStartDate.value = '';
        filterEndDate.value = '';
    }
</script>

<template>
    <div class="flex flex-wrap items-center gap-2">
        <input
            v-model="filterText"
            type="text"
            :placeholder="t('backoffice.sales.filters.order_id_or_dish')"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
        />
        <input
            v-model="filterStartDate"
            type="date"
            :placeholder="t('backoffice.sales.filters.start_date')"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
        />
        <input
            v-model="filterEndDate"
            type="date"
            :placeholder="t('backoffice.sales.filters.end_date')"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
        />

        <button
            @click="clearFilters"
            type="button"
            class="flex items-center gap-2 rounded-lg border border-red-400 bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-red-600 focus:ring-2 focus:ring-red-300 focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

            {{ t('backoffice.sales.filters.clear_filters') }}
        </button>
    </div>
</template>
