<script lang="ts" setup>
    import Logo from '@/components/Main/Logo.vue';
    import { Link } from '@inertiajs/vue3';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <header class="justify-content-around mb-[7px] flex flex-row">
        <Logo />

        <Link class="flex w-1/3 overflow-hidden align-middle whitespace-nowrap" href="/">
            <span class="animate-marquee inline-block self-center font-bold text-[#ffff00]">
                {{ t('main.header.marquee') }}
            </span>
        </Link>

        <Logo />
    </header>
</template>
