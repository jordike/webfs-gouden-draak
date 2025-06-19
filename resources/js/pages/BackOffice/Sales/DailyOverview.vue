<script lang="ts" setup>
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    interface DailyOverview {
        date: string;
    }

    const dailyOverviews = computed(() => (usePage().props.dailyOverviews as DailyOverview[]) || []);

    function formatDate(date: any) {
        if (!date) return '';
        return new Date(date).toLocaleDateString('nl-NL', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="mx-auto mt-[20px] max-w-3xl rounded-xl border border-gray-200 bg-white p-8 shadow-lg">
            <h1 class="mb-3 text-4xl font-bold tracking-tight text-gray-900">Dagelijkse Overzichten</h1>

            <div class="overflow-x-auto rounded-lg border border-gray-100 bg-gray-50">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Datum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Download</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="overview in dailyOverviews" :key="overview.date" class="transition hover:bg-blue-50">
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">{{ formatDate(overview.date) }}</td>
                            <td class="px-6 py-4">
                                <a
                                    :href="`/backoffice/sales/daily-overview/${overview.date}/download`"
                                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"
                                        />
                                    </svg>
                                    Download Excel
                                </a>
                            </td>
                        </tr>
                        <tr v-if="!dailyOverviews.length">
                            <td colspan="2" class="py-10 text-center text-lg text-gray-400">Geen overzichten gevonden.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BackOfficeLayout>
</template>
