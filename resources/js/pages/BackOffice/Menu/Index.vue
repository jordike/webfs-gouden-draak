<script lang="ts" setup>
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { computed, reactive, ref } from 'vue';

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

    // Edit modal state
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
                // Check if category name matches the filter
                const categoryMatches = category.name.toLowerCase().includes(search);
                // Filter items as before
                const filteredItems = category.items.filter(
                    (item) =>
                        item.name.toLowerCase().includes(search) || (item.description ? item.description.toLowerCase().includes(search) : false),
                );

                // If category matches, show all its items; otherwise, only filtered items
                return {
                    ...category,
                    items: categoryMatches ? category.items : filteredItems,
                };
            })
            .filter((category) => category.items.length > 0);
    });

    function editItem(itemId: number) {
        // Find the item and its category
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

    function resetEditItem() {
        editItemData.id = null;
        editItemData.name = '';
        editItemData.description = '';
        editItemData.price = '';
        editItemData.category = props.categories.length ? props.categories[0].name : '';
        editItemData.newCategory = '';
        editItemData.useNewCategory = false;
    }

    function deleteItem(itemId: number) {
        if (confirm('Weet je zeker dat je dit item wilt verwijderen?')) {
            alert(`Verwijder item ${itemId}`);
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
            <!-- ... rest unchanged ... -->
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">Menu Beheer</h1>
                <button
                    class="flex items-center gap-2 rounded bg-green-600 px-5 py-2 font-semibold text-white shadow transition hover:bg-green-700"
                    @click="createNewItem"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nieuw item
                </button>
            </div>
            <!-- ... rest unchanged ... -->
            <div v-for="category in filteredCategories" :key="category.name" class="mb-10">
                <div class="mb-3 flex items-center">
                    <h2 class="text-xl font-semibold text-gray-700">{{ category.name }}</h2>
                    <span class="ml-3 rounded-full bg-gray-200 px-3 py-1 text-xs text-gray-600">{{ category.items.length }} gerechten</span>
                </div>
                <div class="overflow-x-auto rounded bg-white shadow">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Naam</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Beschrijving</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Prijs</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in category.items" :key="item.id" class="transition hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-900" v-html="item.name"></td>
                                <td class="px-6 py-3 text-gray-600" v-html="item.description"></td>
                                <td class="px-6 py-3 font-semibold text-gray-900">€{{ item.price }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex flex-col gap-2 sm:flex-row">
                                        <button
                                            class="flex w-full items-center justify-center rounded bg-blue-500 px-4 py-1 font-medium text-white shadow transition hover:bg-blue-600 sm:w-auto"
                                            @click="editItem(item.id)"
                                            title="Bewerken"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="mr-1 inline h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6"
                                                />
                                            </svg>
                                            Bewerken
                                        </button>
                                        <form :action="`/backoffice/menu/${item.id}`" method="POST">
                                            <input type="hidden" name="_token" :value="csrfToken" />
                                            <input type="hidden" name="_method" value="DELETE" />

                                            <button
                                                type="submit"
                                                class="flex w-full items-center justify-center rounded bg-red-500 px-4 py-1 font-medium text-white shadow transition hover:bg-red-600 sm:w-auto"
                                                title="Verwijderen"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="mr-1 inline h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="category.items.length === 0">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Geen items in deze categorie.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="filteredCategories.length === 0" class="mt-16 text-center text-gray-500">
                Geen items gevonden die overeenkomen met je filter.
            </div>
        </div>

        <!-- Create New Item Modal -->
        <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @mousedown.self="showCreateModal = false">
            <div class="relative w-full max-w-lg rounded bg-white p-8 shadow-lg">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" @click="showCreateModal = false" title="Sluiten">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="mb-6 text-xl font-bold text-gray-800">Nieuw menu-item</h2>
                <form method="post" action="/backoffice/menu">
                    <input type="hidden" name="_token" :value="csrfToken" />

                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Naam *</label>
                        <input
                            v-model="newItem.name"
                            name="name"
                            type="text"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Beschrijving</label>
                        <textarea
                            name="description"
                            v-model="newItem.description"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        ></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Prijs (€) *</label>
                        <input
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
                        <label class="mb-1 block font-medium text-gray-700">Categorie *</label>
                        <div>
                            <select
                                v-model="newItem.category"
                                name="category"
                                class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                @change="newItem.useNewCategory = newItem.category === '__new__'"
                                required
                            >
                                <option value="__new__">Nieuwe categorie...</option>
                                <option disabled>──────────</option>
                                <option v-for="cat in props.categories" :key="cat.name" :value="cat.name">
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>
                        <div v-if="newItem.category === '__new__'" class="mt-2">
                            <input
                                v-model="newItem.newCategory"
                                name="newCategory"
                                type="text"
                                placeholder="Nieuwe categorienaam"
                                class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                required
                            />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" class="rounded bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300" @click="showCreateModal = false">
                            Annuleren
                        </button>
                        <button type="submit" class="rounded bg-green-600 px-4 py-2 font-semibold text-white hover:bg-green-700">Aanmaken</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @mousedown.self="showEditModal = false">
            <div class="relative w-full max-w-lg rounded bg-white p-8 shadow-lg">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" @click="showEditModal = false" title="Sluiten">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="mb-6 text-xl font-bold text-gray-800">Menu-item bewerken</h2>
                <form :action="`/backoffice/menu/${editItemData.id}`" method="post">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <input type="hidden" name="_method" value="PUT" />

                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Naam *</label>
                        <input
                            v-model="editItemData.name"
                            name="name"
                            type="text"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Beschrijving</label>
                        <textarea
                            name="description"
                            v-model="editItemData.description"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        ></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-gray-700">Prijs (€) *</label>
                        <input
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
                        <label class="mb-1 block font-medium text-gray-700">Categorie *</label>
                        <select
                            v-model="editItemData.category"
                            name="category"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            @change="editItemData.useNewCategory = editItemData.category === '__new__'"
                            required
                        >
                            <option value="__new__">Nieuwe categorie...</option>
                            <option disabled>──────────</option>
                            <option v-for="cat in props.categories" :key="cat.name" :value="cat.name">
                                {{ cat.name }}
                            </option>
                        </select>
                        <div v-if="editItemData.category === '__new__'" class="mt-2">
                            <input
                                v-model="editItemData.newCategory"
                                name="newCategory"
                                type="text"
                                placeholder="Nieuwe categorienaam"
                                class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                required
                            />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" class="rounded bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300" @click="showEditModal = false">
                            Annuleren
                        </button>
                        <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </BackOfficeLayout>
</template>
