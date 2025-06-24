<script lang="ts" setup>
    import GoldenBorder from '@/components/Main/border/GoldenBorder.vue';
    import Header from '@/components/Main/Header.vue';
    import NavBar from '@/components/Main/NavBar.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <Head>
        <title>{{ t('restaurant_name') }}</title>
    </Head>

    <main class="flex-column justify-content-center flex min-h-screen bg-[#8b0000] font-serif text-white">
        <div class="container mx-[50px] my-[15px] bg-[#ff0000]">
            <Header />

            <GoldenBorder>
                <NavBar />

                <div class="mt-[50px]">
                    <slot />
                </div>

                <Link class="mt-4 text-center text-[#ffff00]" href="/contact">
                    {{ t('main.navbar.go_to_contact') }}
                </Link>
            </GoldenBorder>
        </div>
    </main>
</template>
