<script lang="ts" setup>
    import AppLayout from '@/layouts/AppLayout.vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <AppLayout>
        <section class="p- mx-[50px] border-1 border-black bg-white p-[5px] text-center font-bold text-black">
            <p class="my-[20px]">
                <span v-html="t('main.news.message')"></span>
            </p>
        </section>
    </AppLayout>
</template>
