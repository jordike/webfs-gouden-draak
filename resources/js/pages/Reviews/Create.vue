<script setup lang="ts">
    import { ref } from 'vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    const props = defineProps<{
        stored: boolean;
        csrfToken: string;
        order_id: number;
    }>();

    const stored = ref(props.stored);

    interface ReviewForm {
        name: string;
        rating: number;
        atmosphere_rating: number;
        service_rating: string;
        favorite_food: string;
        improvement_suggestions: string;
    }

    const form = ref<ReviewForm>({
        name: '',
        rating: 0,
        atmosphere_rating: 0,
        service_rating: '',
        favorite_food: '',
        improvement_suggestions: '',
    });

    const hoverRating = ref(0);
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-lg">
            <div v-if="stored" class="text-center">
                <h1 class="mb-4 text-2xl font-bold text-green-700">{{ t('backoffice.reviews.thank_you_title') }}</h1>
                <p class="text-gray-700">{{ t('backoffice.reviews.thank_you_message') }}</p>
            </div>

            <div v-else>
                <h1
                    class="mb-6 bg-gradient-to-r from-yellow-700 via-yellow-500 to-yellow-400 bg-clip-text text-center text-3xl font-extrabold text-transparent drop-shadow-lg"
                >
                    {{ t('backoffice.reviews.leave_review') }}
                </h1>

                <form action="#" method="POST" class="space-y-8">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <input type="hidden" name="order_id" :value="order_id" />

                    <div>
                        <label for="name" class="mb-1 block font-semibold text-yellow-900">
                            {{ t('backoffice.reviews.form.name') }}
                            <span class="font-normal text-yellow-400">{{ t('backoffice.reviews.form.name_optional') }} </span>:
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            v-model="form.name"
                            class="w-full rounded-xl border border-yellow-300 px-4 py-2 shadow transition-all duration-200 focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                            :placeholder="t('backoffice.reviews.form.name_placeholder')"
                        />
                    </div>

                    <div>
                        <label class="mb-1 block font-semibold text-yellow-900" for="rating">{{ t('backoffice.reviews.form.rating') }}</label>
                        <input id="rating" type="hidden" name="rating" :value="form.rating" />
                        <div class="flex justify-center gap-2">
                            <button
                                v-for="star in 5"
                                :key="star"
                                type="button"
                                @click="form.rating = star"
                                @mouseover="hoverRating = star"
                                @mouseleave="hoverRating = 0"
                                class="cursor-pointer border-none bg-transparent p-0 text-4xl transition-transform duration-150 focus:outline-none"
                                :class="{
                                    'scale-125 text-yellow-500 drop-shadow-lg': (hoverRating || form.rating) >= star,
                                    'text-yellow-200': (hoverRating || form.rating) < star,
                                }"
                                :aria-label="t('backoffice.reviews.form.stars_aria', { count: star })"
                            >
                                <span v-if="(hoverRating || form.rating) >= star">★</span>
                                <span v-else>☆</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block font-semibold text-yellow-900" for="atmosphere_rating">
                            {{ t('backoffice.reviews.form.atmosphere') }}
                        </label>
                        <div class="flex justify-center gap-3">
                            <span
                                v-for="(emoji, idx) in ['😞', '😐', '😊', '😁', '🤩']"
                                :key="emoji"
                                class="cursor-pointer text-3xl transition-transform duration-150"
                                :class="{
                                    'scale-150 text-yellow-600 drop-shadow-lg': form.atmosphere_rating === idx + 1,
                                    'text-yellow-400 opacity-60': form.atmosphere_rating !== 0 && form.atmosphere_rating !== idx + 1,
                                }"
                                @click="form.atmosphere_rating = idx + 1"
                                :aria-label="t('backoffice.reviews.form.atmosphere_aria', { count: idx + 1 })"
                            >
                                {{ emoji }}
                            </span>
                        </div>
                        <input type="hidden" id="atmosphere_rating" name="atmosphere_rating" :value="form.atmosphere_rating" />
                    </div>

                    <!-- Service beoordeling -->
                    <div>
                        <label class="mb-1 block font-semibold text-yellow-900">
                            {{ t('backoffice.reviews.form.service') }}
                        </label>
                        <div class="flex justify-center gap-4">
                            <label
                                v-for="(option, idx) in [
                                    t('backoffice.reviews.labels.bad'),
                                    t('backoffice.reviews.labels.average'),
                                    t('backoffice.reviews.labels.good'),
                                    t('backoffice.reviews.labels.excellent'),
                                ]"
                                :key="option"
                                class="flex cursor-pointer items-center gap-2 rounded-full px-3 py-1 transition-all duration-150"
                                :class="{
                                    'bg-yellow-100 font-bold text-yellow-800 shadow': form.service_rating === option,
                                    'bg-yellow-50 text-yellow-600': form.service_rating !== option,
                                }"
                            >
                                <input
                                    type="radio"
                                    name="service_rating"
                                    :value="idx + 1"
                                    v-model.number="form.service_rating"
                                    class="accent-yellow-600"
                                />
                                <span>{{ option }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Favoriet gerecht -->
                    <div>
                        <label for="favorite_food" class="mb-1 block font-semibold text-yellow-900">
                            {{ t('backoffice.reviews.form.favorite_food') }}
                            <span class="font-normal text-yellow-400">
                                {{ t('backoffice.reviews.form.favorite_food_optional') }}
                            </span>
                            :
                        </label>
                        <input
                            id="favorite_food"
                            name="favorite_food"
                            type="text"
                            v-model="form.favorite_food"
                            class="w-full rounded-xl border border-yellow-300 px-4 py-2 shadow transition-all duration-200 focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                            :placeholder="t('backoffice.reviews.form.favorite_food_placeholder')"
                        />
                    </div>

                    <div>
                        <label for="improvement_suggestions" class="mb-1 block font-semibold text-yellow-900">
                            {{ t('backoffice.reviews.form.improvement_suggestions') }}
                            <span class="font-normal text-yellow-400">
                                {{ t('backoffice.reviews.form.improvement_suggestions_optional') }}
                            </span>
                            :
                        </label>
                        <textarea
                            id="improvement_suggestions"
                            name="improvement_suggestions"
                            v-model="form.improvement_suggestions"
                            class="w-full resize-none rounded-xl border border-yellow-300 px-4 py-2 shadow transition-all duration-200 focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                            rows="4"
                            :placeholder="t('backoffice.reviews.form.improvement_suggestions_placeholder')"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-yellow-600 via-yellow-500 to-yellow-400 px-6 py-3 font-bold text-white shadow-lg transition-transform hover:scale-105 hover:shadow-xl focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                    >
                        {{ t('backoffice.reviews.form.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
