<script lang="ts" setup>
    import Header from '@/components/BackOffice/Header.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>The Golden Dragon</title>
    </Head>

    <Header />
    <slot />
</template>
