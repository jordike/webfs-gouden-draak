<script lang="ts" setup>
    import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="flex flex-col">
            <section class="border-1 border-black bg-white p-[5px] text-center font-bold text-black">
                <p class="my-[20px]">De Gouden Draak is eenvoudig te vinden, vlak bij het centrum, 5 minuten lopen achter het centraal station.</p>
                <p class="mb-[20px]">
                    Onderwijsboulevard 215, kamer OG112 <br />
                    5223 DE 's-Hertogenbosch
                </p>
            </section>

            <img class="w-[100%] self-center" src="/assets/img/map.png" alt="Locatie van de Gouden Draak op de kaart" />
        </div>
    </AppLayout>
</template>
