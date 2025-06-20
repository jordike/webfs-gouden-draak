<script lang="ts" setup>
    import CategoryTable from '@/components/BackOffice/Menu/CategoryTable.vue';
    import CreateItemModal from '@/components/BackOffice/Menu/CreateItemModal.vue';
    import EditItemModal from '@/components/BackOffice/Menu/EditItemModal.vue';
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { computed, reactive, ref } from 'vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();

    const props = defineProps<{
        categories: Array<{
            name: string;
            items: Array<{
                id: number;
                name: string;
                description: string;
                price: number;
            }>;
        }>;
        csrfToken: string;
    }>();

    const filter = ref('');
    const showCreateModal = ref(false);

    const newItem = reactive({
        name: '',
        description: '',
        price: '',
        category: '',
        newCategory: '',
        useNewCategory: false,
    });

    const showEditModal = ref(false);
    const editItemData = reactive({
        id: null as number | null,
        name: '',
        description: '',
        price: '',
        category: '',
        newCategory: '',
        useNewCategory: false,
    });

    const filteredCategories = computed(() => {
        if (!filter.value.trim()) return props.categories;

        const search = filter.value.toLowerCase();

        return props.categories
            .map((category) => {
                const categoryMatches = category.name.toLowerCase().includes(search);
                const filteredItems = category.items.filter(
                    (item) =>
                        item.name.toLowerCase().includes(search) || (item.description ? item.description.toLowerCase().includes(search) : false),
                );

                return {
                    ...category,
                    items: categoryMatches ? category.items : filteredItems,
                };
            })
            .filter((category) => category.items.length > 0);
    });

    function editItem(itemId: number): void {
        for (const category of props.categories) {
            const item = category.items.find((i) => i.id === itemId);

            if (item) {
                editItemData.id = item.id;
                editItemData.name = item.name;
                editItemData.description = item.description;
                editItemData.price = item.price.toString();
                editItemData.category = category.name;
                editItemData.newCategory = '';
                editItemData.useNewCategory = false;
                showEditModal.value = true;

                break;
            }
        }
    }

    function createNewItem() {
        resetNewItem();

        showCreateModal.value = true;
    }

    function resetNewItem() {
        newItem.name = '';
        newItem.description = '';
        newItem.price = '';
        newItem.category = props.categories.length ? props.categories[0].name : '';
        newItem.newCategory = '';
        newItem.useNewCategory = false;
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-col gap-2">
                    <h1 class="text-2xl font-bold text-gray-800">{{ t('backoffice.menu.title') }}</h1>
                    <input
                        v-model="filter"
                        type="text"
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-gray-700 focus:border-green-500 focus:outline-none md:w-72"
                        :placeholder="t('backoffice.menu.filter_placeholder')"
                    />
                </div>

                <button
                    class="flex items-center gap-2 rounded bg-green-600 px-5 py-2 font-semibold text-white shadow transition hover:bg-green-700"
                    @click="createNewItem"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ t('backoffice.menu.new_item') }}
                </button>
            </div>

            <div v-for="category in filteredCategories" :key="category.name">
                <CategoryTable :category="category" :csrfToken="props.csrfToken" @edit="editItem" />
            </div>

            <div v-if="filteredCategories.length === 0" class="mt-16 text-center text-gray-500">
                {{ t('backoffice.menu.none_found') }}
            </div>
        </div>

        <CreateItemModal
            :show="showCreateModal"
            :newItem="newItem"
            :categories="props.categories"
            :csrfToken="props.csrfToken"
            @close="showCreateModal = false"
        />

        <EditItemModal
            :show="showEditModal"
            :editItemData="editItemData"
            :categories="props.categories"
            :csrfToken="props.csrfToken"
            @close="showEditModal = false"
        />
    </BackOfficeLayout>
</template>
