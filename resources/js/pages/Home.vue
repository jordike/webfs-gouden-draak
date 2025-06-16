<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <section class="p- mx-[50px] border-1 border-black bg-white p-[5px] text-center font-bold text-black">
            <p class="mb-[20px]">
                Al jaren is De Gouden Draak een begrip als het gaat om de beste afhaalgerechten in 's-Hertogenbosch. <br />
                Graag trakteren we u op authentieke gerechten uit de Cantonese keuken.
            </p>
            <h3 class="mb-3 text-[20px] underline">Speciale Studentenaanbieding</h3>
            <h4 class="text-[30px]">Chinese Rijsttafel (2 personen)</h4>
            <p>Maak een keuze uit 3 van onze onderstaande keuzegerechten:</p>

            <div class="my-6 flex flex-col items-center">
                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">Koe Loe Yuk</span>
                    <span class="w-80 text-left">Foe Yong Hai</span>
                </div>
                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">Tjap Tjoy</span>
                    <span class="w-80 text-left">Garnalen met Gebakken Knoflook</span>
                </div>
                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">Babi Pangang</span>
                    <span class="w-80 text-left">Kipfilet in Zwarte Bonen saus</span>
                </div>
            </div>

            <p class="mb-3">Met witte rijst. (Nasi of bami voor meerprijs mogelijk.)</p>
            <p class="text-[30px]">Prijs: &euro;21,00</p>
        </section>
    </AppLayout>
</template>
