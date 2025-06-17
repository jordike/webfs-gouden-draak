<script lang="ts" setup>
    import { defineEmits, defineProps } from 'vue';

    const props = defineProps<{
        item: any;
    }>();

    const emit = defineEmits(['add']);
</script>

<template>
    <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-white p-5 shadow transition hover:shadow-lg">
        <div>
            <div class="mb-1">
                <span class="inline-block rounded bg-green-100 px-2 py-0.5 font-mono text-xs font-bold text-green-700 shadow-sm">
                    #{{ item.id }}
                </span>
            </div>
            <div class="flex items-center gap-2 font-semibold text-gray-800">
                <span v-html="item.name"></span>
            </div>
            <div v-if="item.description" class="mt-1 text-sm text-gray-500" v-html="item.description"></div>
            <div class="mt-1 font-bold text-green-600">€{{ item.price }}</div>
        </div>
        <button
            class="ml-3 rounded-full bg-gradient-to-br from-green-500 to-green-600 p-3 text-white shadow transition hover:from-green-600 hover:to-green-700 focus:ring-2 focus:ring-green-300 focus:outline-none"
            title="Toevoegen"
            @click="$emit('add', item)"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>
</template>
