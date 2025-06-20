<script lang="ts" setup>
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    defineProps<{
        show: boolean;
        editItemData: {
            id: number | null;
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

            <h2 class="mb-6 text-xl font-bold text-gray-800">{{ t('backoffice.menu.edit_item') }}</h2>

            <form :action="`/backoffice/menu/${editItemData.id}`" method="post">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="_method" value="PUT" />

                <div class="mb-4">
                    <label for="edititem-name" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.name') }} *</label>
                    <input
                        id="edititem-name"
                        v-model="editItemData.name"
                        name="name"
                        type="text"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="edititem-description" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.description') }}</label>
                    <textarea
                        id="edititem-description"
                        name="description"
                        v-model="editItemData.description"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label for="edititem-price" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.price') }} *</label>
                    <input
                        id="edititem-price"
                        v-model="editItemData.price"
                        name="price"
                        type="number"
                        min="0"
                        step="0.01"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="edititem-category" class="mb-1 block font-medium text-gray-700">{{ t('backoffice.menu.category') }} *</label>
                    <select
                        id="edititem-category"
                        v-model="editItemData.category"
                        name="category"
                        class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        @change="editItemData.useNewCategory = editItemData.category === '__new__'"
                        required
                    >
                        <option value="__new__">{{ t('backoffice.menu.new_category') }}</option>
                        <option disabled>──────────</option>
                        <option v-for="cat in categories" :key="cat.name" :value="cat.name">
                            {{ cat.name }}
                        </option>
                    </select>

                    <div v-if="editItemData.category === '__new__'" class="mt-2">
                        <input
                            id="edititem-newcategory"
                            v-model="editItemData.newCategory"
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
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                        {{ t('backoffice.menu.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
