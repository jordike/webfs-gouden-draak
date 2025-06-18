<template>
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
</template>

<script lang="ts" setup>
    const props = defineProps<{
        filterText: string;
        filterStartDate: string;
        filterEndDate: string;
    }>();
    const emit = defineEmits(['update:filterText', 'update:filterStartDate', 'update:filterEndDate']);

    // v-model bindings for parent sync
    const filterText = defineModel('filterText');
    const filterStartDate = defineModel('filterStartDate');
    const filterEndDate = defineModel('filterEndDate');
</script>
