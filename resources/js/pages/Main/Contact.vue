<script lang="ts" setup>
    import AppLayout from '@/layouts/AppLayout.vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <AppLayout>
        <div class="flex flex-col">
            <section class="border-1 border-black bg-white p-[5px] text-center font-bold text-black">
                <p class="my-[20px]">
                    {{ t('main.contact.instructions') }}
                </p>
                <p class="mb-[20px]" v-html="t('main.contact.address')"></p>
            </section>

            <img class="w-[100%] self-center" src="/assets/img/map.png" alt="Locatie van de Gouden Draak op de kaart" />
        </div>
    </AppLayout>
</template>
