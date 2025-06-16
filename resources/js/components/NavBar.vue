<script lang="ts" setup>
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-row justify-between">
        <img class="h-[200px]" src="/assets/img/dragon-small.png" alt="Golden Dragon" />

        <section>
            <h1 class="mb-3 text-center text-[40px] font-bold text-[#ffff00]">
                Chinees Indische Specaliteiten <br />
                De Gouden Draak
            </h1>

            <nav class="flex flex-row justify-center gap-[3px]">
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/menukaart">Menukaart</Link>
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/nieuws">Nieuws</Link>
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/contact">Contact</Link>
            </nav>
        </section>

        <img class="h-[200px]" src="/assets/img/dragon-small-flipped.png" alt="Golden Dragon Flipped" />
    </div>
</template>
