<script lang="ts" setup>
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    interface Review {
        id: number;
        name: string | null;
        rating: number;
        atmosphere_rating: number;
        service_rating: number;
        favorite_food: string | null;
        improvement_suggestions: string | null;
        created_at: string;
    }

    const page = usePage();
    const reviews = computed<Review[]>(() => page.props.reviews as Review[]);

    function formatDate(dateStr: string) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('nl-NL', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    }

    const serviceIcons = [
        { label: 'Slecht', icon: '👎', color: 'text-red-500' },
        { label: 'Matig', icon: '😐', color: 'text-yellow-500' },
        { label: 'Goed', icon: '👍', color: 'text-green-500' },
        { label: 'Uitstekend', icon: '🌟', color: 'text-yellow-700' },
    ];

    const atmosphereIcons = [
        { icon: '😞', label: 'Slecht', color: 'text-red-400' },
        { icon: '😐', label: 'Matig', color: 'text-yellow-500' },
        { icon: '😊', label: 'Goed', color: 'text-green-500' },
        { icon: '😁', label: 'Erg goed', color: 'text-green-600' },
        { icon: '🤩', label: 'Uitstekend', color: 'text-yellow-700' },
    ];
</script>

<template>
    <BackOfficeLayout>
        <div class="p-[20px]">
            <h1 class="mb-6 text-2xl font-bold text-gray-800">Reviews</h1>
            <div v-if="reviews.length === 0" class="text-gray-500">Nog geen reviews.</div>
            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 rounded-lg bg-white shadow">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Naam</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Datum</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Beoordeling</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Sfeer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Service</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Favoriet gerecht</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Suggesties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="review in reviews" :key="review.id" class="transition hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-lg font-bold text-gray-600 shadow-inner"
                                    >
                                        <span v-if="review.name">{{ review.name.charAt(0).toUpperCase() }}</span>
                                        <span v-else>A</span>
                                    </div>
                                    <span class="font-medium">{{ review.name || 'Anoniem' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs whitespace-nowrap text-gray-500">{{ formatDate(review.created_at) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    <span
                                        v-for="star in 5"
                                        :key="star"
                                        class="text-xl"
                                        :class="star <= review.rating ? 'text-yellow-400' : 'text-gray-200'"
                                        >★</span
                                    >
                                    <span
                                        class="ml-2 rounded-full border px-2 py-0.5 text-xs font-semibold"
                                        :class="[
                                            review.rating >= 4
                                                ? 'border-green-200 bg-green-50 text-green-700'
                                                : review.rating === 3
                                                  ? 'border-yellow-200 bg-yellow-50 text-yellow-700'
                                                  : 'border-red-200 bg-red-50 text-red-700',
                                        ]"
                                    >
                                        {{ review.rating }}/5
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    v-if="review.atmosphere_rating >= 1 && review.atmosphere_rating <= 5"
                                    :class="atmosphereIcons[review.atmosphere_rating - 1].color + ' text-xl'"
                                >
                                    {{ atmosphereIcons[review.atmosphere_rating - 1].icon }}
                                    <span class="ml-1 text-xs text-gray-500">{{ atmosphereIcons[review.atmosphere_rating - 1].label }}</span>
                                </span>
                                <span v-else>Onbekend</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    v-if="review.service_rating >= 1 && review.service_rating <= 4"
                                    :class="serviceIcons[review.service_rating - 1].color + ' text-xl'"
                                >
                                    {{ serviceIcons[review.service_rating - 1].icon }}
                                    <span class="ml-1 text-xs text-gray-500">{{ serviceIcons[review.service_rating - 1].label }}</span>
                                </span>
                                <span v-else>Onbekend</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ review.favorite_food || '—' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ review.improvement_suggestions || '—' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BackOfficeLayout>
</template>
