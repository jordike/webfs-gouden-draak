<script lang="ts" setup>
    import { defineEmits, defineProps } from 'vue';

    defineProps<{
        orderItem: any;
        idx: number;
    }>();

    defineEmits(['increase', 'decrease', 'remove']);
</script>

<template>
    <li class="flex items-center justify-between rounded-lg border border-gray-100 bg-gray-50 px-4 py-3 shadow-sm transition hover:shadow">
        <input type="hidden" :name="`items[${idx}][id]`" :value="orderItem.id" />
        <input type="hidden" :name="`items[${idx}][amount]`" :value="orderItem.amount || 1" />

        <div class="flex flex-col">
            <div class="mb-1">
                <span class="inline-block rounded bg-green-100 px-2 py-0.5 font-mono text-xs font-bold text-green-700 shadow-sm">
                    #{{ orderItem.id }}
                </span>
            </div>
            <div class="flex items-center gap-2 font-semibold text-gray-800">
                <span v-html="orderItem.name"></span>
            </div>
            <div v-if="orderItem.description" class="mt-1 text-sm text-gray-500" v-html="orderItem.description"></div>
            <div class="mt-1 font-bold text-green-600">€{{ orderItem.price }}</div>
        </div>

        <div class="ml-4 flex items-center gap-1">
            <button
                class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-lg text-gray-600 transition hover:bg-gray-300"
                @click.prevent="$emit('decrease', idx)"
                title="Verlaag aantal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
            </button>

            <span class="min-w-[2rem] rounded border border-gray-200 bg-white px-2 py-1 text-center font-bold text-gray-700">
                {{ orderItem.amount || 1 }}
            </span>

            <button
                class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-lg text-gray-600 transition hover:bg-gray-300"
                @click.prevent="$emit('increase', idx)"
                title="Verhoog aantal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>

            <button
                class="ml-2 flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-500 transition hover:bg-red-200"
                @click.prevent="$emit('remove', idx)"
                title="Verwijder item"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </li>
</template>
