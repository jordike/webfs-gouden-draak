<script lang="ts" setup>
    import GoldenBorder from '@/components/border/GoldenBorder.vue';
    import Header from '@/components/Header.vue';
    import NavBar from '@/components/NavBar.vue';
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <main class="flex-column justify-content-center flex text-white">
        <div class="container mx-[50px] my-[15px] bg-[#ff0000]">
            <Header />

            <GoldenBorder>
                <NavBar />

                <div class="mt-[50px]">
                    <slot />
                </div>

                <Link class="mt-3 text-center" href="/contact"> Naar Contact </Link>
            </GoldenBorder>
        </div>
    </main>
</template>
