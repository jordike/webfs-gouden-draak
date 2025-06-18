<template>
    <div
        class="mb-6 flex flex-col gap-2 rounded-lg bg-gradient-to-r from-green-50 to-blue-50 p-4 shadow-sm md:flex-row md:items-center md:justify-end md:gap-8"
    >
        <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
            <span class="inline-block min-w-[160px]">Totaal (incl. btw):</span>
            <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm"> € {{ totalPrice.toFixed(2) }} </span>
        </span>
        <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
            <span class="inline-block min-w-[140px]">Totaal btw (21%):</span>
            <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm"> € {{ totalVAT.toFixed(2) }} </span>
        </span>
        <span class="flex items-center gap-2 text-base font-semibold text-blue-900">
            <span class="inline-block min-w-[160px]">Totaal (excl. btw):</span>
            <span class="rounded border border-green-200 bg-green-100 px-2 py-1 text-green-800 shadow-sm"> € {{ totalExclVAT.toFixed(2) }} </span>
        </span>
    </div>
</template>

<script lang="ts" setup>
    const props = defineProps<{
        totalPrice: number;
        totalVAT: number;
        totalExclVAT: number;
    }>();
</script>
