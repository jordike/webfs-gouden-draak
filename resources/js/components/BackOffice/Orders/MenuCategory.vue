<script lang="ts" setup>
    import { defineEmits, defineProps } from 'vue';
    import MenuItemCard from './MenuItemCard.vue';

    const props = defineProps<{
        category: any;
    }>();
    const emit = defineEmits(['add-item']);
</script>

<template>
    <div class="mb-10">
        <h2 class="mb-4 flex items-center gap-2 border-b-2 border-green-100 pb-2 text-xl font-semibold text-green-700">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V7h2v2z" />
            </svg>
            {{ category.name }}
        </h2>
        <ul class="grid gap-5 sm:grid-cols-2">
            <li v-for="item in category.items" :key="item.id">
                <MenuItemCard :item="item" @add="$emit('add-item', $event)" />
            </li>
        </ul>
    </div>
</template>
