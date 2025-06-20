<script lang="ts" setup>
    import BackOfficeLayout from '@/layouts/BackOfficeLayout.vue';
    import { reactive, ref } from 'vue';
    import { useI18n } from 'vue-i18n';
    const { t } = useI18n();

    const props = defineProps<{
        tables: Array<{
            id: number;
            use_deluxe_menu: boolean;
            customers: Array<{ id: number; name: string; age: number | null }>;
        }>;
        csrfToken: string;
    }>();

    const showModal = ref(false);
    const isEdit = ref(false);
    const modalTableId = ref<number | null>(null);

    const modalForm = reactive({
        use_deluxe_menu: false,
        customers: Array.from({ length: 8 }, () => ({ name: '', age: null })),
    });

    function openAddModal() {
        isEdit.value = false;
        modalTableId.value = null;
        modalForm.use_deluxe_menu = false;
        modalForm.customers = Array.from({ length: 8 }, () => ({ name: '', age: '' }));
        showModal.value = true;
    }

    function openEditModal(table: any) {
        isEdit.value = true;
        modalTableId.value = table.id;
        modalForm.use_deluxe_menu = !!table.use_deluxe_menu;
        const customersArr = Array.isArray(table.customers) ? table.customers : [];
        modalForm.customers = Array.from({ length: 8 }, (_, i) => {
            const c = customersArr[i];
            return {
                name: c ? c.name : '',
                age: c && c.age !== null && c.age !== undefined ? c.age : null,
            };
        });
        showModal.value = true;
    }

    function closeModal() {
        showModal.value = false;
    }

    function submitModal() {
        // Submit via form POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = isEdit.value ? `/backoffice/tables/${modalTableId.value}` : '/backoffice/tables';
        if (isEdit.value) {
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);
        }
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = props.csrfToken;
        form.appendChild(token);

        const deluxe = document.createElement('input');
        deluxe.type = 'hidden';
        deluxe.name = 'use_deluxe_menu';
        deluxe.value = modalForm.use_deluxe_menu ? '1' : '0';
        form.appendChild(deluxe);

        modalForm.customers.forEach((c, i) => {
            if (c.name.trim() !== '') {
                const name = document.createElement('input');
                name.type = 'hidden';
                name.name = `customers[${i}][name]`;
                name.value = c.name;
                form.appendChild(name);

                const age = document.createElement('input');
                age.type = 'hidden';
                age.name = `customers[${i}][age]`;
                age.value = c.age !== null && c.age !== undefined ? String(c.age) : '';
                form.appendChild(age);
            }
        });

        document.body.appendChild(form);
        form.submit();
    }

    function deleteTable(id: number) {
        if (!confirm('Weet je zeker dat je deze tafel wilt verwijderen?')) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/backoffice/tables/${id}`;
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = props.csrfToken;
        form.appendChild(token);
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
</script>

<template>
    <BackOfficeLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">{{ t('backoffice.pages.tables.title') }}</h1>
                <button
                    class="flex items-center gap-2 rounded bg-blue-600 px-5 py-2 font-semibold text-white shadow transition hover:bg-blue-700"
                    @click="openAddModal"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ t('backoffice.pages.tables.new_table') }}
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-100 bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">
                                {{ t('backoffice.pages.tables.num_customers') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">
                                {{ t('backoffice.pages.tables.deluxe_menu') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">
                                {{ t('backoffice.pages.tables.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="table in props.tables" :key="table.id" class="transition hover:bg-blue-50">
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
                                {{ t('backoffice.pages.tables.table') }} {{ table.id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-blue-700">{{ (table.customers ?? []).length }}</span>
                                <span class="text-gray-500"> / 8</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1 rounded px-2 py-1 text-xs font-semibold"
                                    :class="table.use_deluxe_menu ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                >
                                    <svg
                                        v-if="table.use_deluxe_menu"
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ table.use_deluxe_menu ? t('backoffice.pages.tables.yes') : t('backoffice.pages.tables.no') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    class="mr-2 rounded bg-yellow-400 px-3 py-1 text-sm font-semibold text-white shadow hover:bg-yellow-500"
                                    @click="openEditModal(table)"
                                >
                                    {{ t('backoffice.pages.tables.edit') }}
                                </button>
                                <button
                                    class="rounded bg-red-500 px-3 py-1 text-sm font-semibold text-white shadow hover:bg-red-600"
                                    @click="deleteTable(table.id)"
                                >
                                    {{ t('backoffice.pages.tables.delete') }}
                                </button>
                            </td>
                        </tr>
                        <tr v-if="props.tables.length === 0">
                            <td colspan="4" class="py-10 text-center text-lg text-gray-400">{{ t('backoffice.pages.tables.not_found') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @mousedown.self="closeModal">
                <div class="relative w-full max-w-lg rounded-lg bg-white p-8 shadow-lg">
                    <button
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        @click="closeModal"
                        :title="t('backoffice.pages.tables.close')"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h2 class="mb-6 text-2xl font-bold text-gray-800">
                        {{ isEdit ? t('backoffice.pages.tables.edit_table') : t('backoffice.pages.tables.add_table') }}
                    </h2>
                    <form @submit.prevent="submitModal">
                        <label for="deluxe-menu-yes" class="mb-2 block font-semibold text-gray-700">{{
                            t('backoffice.pages.tables.deluxe_menu')
                        }}</label>
                        <div class="mb-3 flex items-center gap-4">
                            <label class="inline-flex items-center">
                                <input id="deluxe-menu-yes" type="radio" v-model="modalForm.use_deluxe_menu" :value="true" class="form-radio" />
                                <span class="ml-2">{{ t('backoffice.pages.tables.yes') }}</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input id="deluxe-menu-no" type="radio" v-model="modalForm.use_deluxe_menu" :value="false" class="form-radio" />
                                <span class="ml-2">{{ t('backoffice.pages.tables.no') }}</span>
                            </label>
                        </div>
                        <label for="customer-name-0" class="mb-2 block font-semibold text-gray-700">{{
                            t('backoffice.pages.tables.customers')
                        }}</label>
                        <div class="grid grid-cols-1 gap-3">
                            <div v-for="(customer, idx) in modalForm.customers" :key="idx" class="flex items-center gap-2">
                                <input
                                    :id="`customer-name-${idx}`"
                                    v-model="customer.name"
                                    type="text"
                                    class="w-1/2 rounded border px-3 py-1"
                                    :placeholder="t('backoffice.pages.tables.customer_name_placeholder', { number: idx + 1 })"
                                    maxlength="255"
                                />
                                <input
                                    :id="`customer-age-${idx}`"
                                    v-model="modalForm.customers[idx].age"
                                    type="number"
                                    min="0"
                                    class="w-1/4 rounded border px-3 py-1"
                                    :placeholder="t('backoffice.pages.tables.customer_age_placeholder')"
                                />
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-4">
                            <button
                                type="button"
                                class="w-full rounded bg-gray-200 px-4 py-2 text-gray-700 shadow hover:bg-gray-300"
                                @click="closeModal"
                            >
                                {{ t('backoffice.pages.tables.cancel') }}
                            </button>
                            <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow hover:bg-blue-700">
                                {{ isEdit ? t('backoffice.pages.tables.save') : t('backoffice.pages.tables.add') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BackOfficeLayout>
</template>

<style scoped>
    /* Add any component-specific styles here */
</style>
