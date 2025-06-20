<script lang="ts" setup>
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    defineProps<{
        show: boolean;
        newItem: {
            name: string;
            description: string;
            price: string;
            category: string;
            newCategory: string;
            useNewCategory: boolean;
        };
        categories: Array<{ name: string }>;
        csrfToken: string;
    }>();

    defineEmits(['close']);
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @mousedown.self="$emit('close')">
        <div class="relative w-full max-w-lg rounded bg-white p-8 shadow-lg">
            <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" @click="$emit('close')" :title="t('backoffice.menu.cancel')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="mb-6 text-xl font-bold text-gray-800">{{ t('backoffice.menu.new_item') }}</h2>

            <form method="post" action="/backoffice/menu">
                <input type="hidden" name="token" :value="csrfToken" />

                <div class="mb-4">
                    <label for="newitem-name" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.name') }} *</label>
                    <input
                        id="newitem-name"
                        v-model="newItem.name"
                        name="name"
                        type="text"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="newitem-description" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.description') }}</label>
                    <textarea
                        id="newitem-description"
                        name="description"
                        v-model="newItem.description"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label for="newitem-price" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.price') }} *</label>
                    <input
                        id="newitem-price"
                        v-model="newItem.price"
                        name="price"
                        type="number"
                        min="0"
                        step="0.01"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="newitem-category" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.category') }} *</label>
                    <select
                        id="newitem-category"
                        v-model="newItem.category"
                        name="category"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        @change="newItem.useNewCategory = newItem.category === '__new__'"
                        required
                    >
                        <option value="__new__">{{ t('backoffice.menu.new_category') }}</option>
                        <option disabled>──────────</option>
                        <option v-for="cat in categories" :key="cat.name" :value="cat.name">
                            {{ cat.name }}
                        </option>
                    </select>

                    <div v-if="newItem.category === '__new__'" class="mt-2">
                        <input
                            id="newitem-newcategory"
                            v-model="newItem.newCategory"
                            name="newCategory"
                            type="text"
                            :placeholder="t('backoffice.menu.new_category')"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required
                        />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" class="rounded bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300" @click="$emit('close')">
                        {{ t('backoffice.menu.cancel') }}
                    </button>
                    <button type="submit" class="rounded bg-green-600 px-4 py-2 font-semibold text-white hover:bg-green-700">
                        {{ t('backoffice.menu.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
