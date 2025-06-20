<script lang="ts" setup>
    import Header from '@/components/BackOffice/Header.vue';
    import { Head } from '@inertiajs/vue3';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <Head>
        <title>{{ t('restaurant_name') }}</title>
    </Head>

    <Header />
    <slot />
</template>
