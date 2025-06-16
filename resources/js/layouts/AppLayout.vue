<script lang="ts" setup>
    import GoldenBorder from '@/components/border/GoldenBorder.vue';
    import Header from '@/components/Header.vue';
    import NavBar from '@/components/NavBar.vue';
</script>

<template>
    <main class="flex-column justify-content-center flex text-white">
        <div class="container mx-[50px] my-[15px] bg-[#ff0000]">
            <Header />

            <GoldenBorder>
                <NavBar />

                <slot />
            </GoldenBorder>
        </div>
    </main>
</template>
