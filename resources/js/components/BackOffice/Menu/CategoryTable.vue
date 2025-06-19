<script lang="ts" setup>
    defineProps<{
        category: {
            name: string;
            items: Array<{
                id: number;
                name: string;
                description: string;
                price: number;
            }>;
        };
        csrfToken: string;
    }>();

    defineEmits(['edit']);
</script>

<template>
    <div class="mb-10">
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
                                    @click="$emit('edit', item.id)"
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
</template>
