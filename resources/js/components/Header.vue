<script lang="ts" setup>
    import Logo from '@/components/Logo.vue';
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <header class="justify-content-around mb-[7px] flex flex-row">
        <Logo />

        <Link class="flex w-1/3 overflow-hidden align-middle whitespace-nowrap" href="/">
            <span class="animate-marquee inline-block self-center font-bold text-[#ffff00]">
                Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
            </span>
        </Link>

        <Logo />
    </header>
</template>
