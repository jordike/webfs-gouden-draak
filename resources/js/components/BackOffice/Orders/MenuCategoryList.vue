<script lang="ts" setup>
    import { defineEmits, defineProps } from 'vue';
    import MenuCategory from './MenuCategory.vue';

    const props = defineProps<{
        categories: Array<any>;
    }>();
    const emit = defineEmits(['add-item']);
</script>

<template>
    <div>
        <div v-for="category in categories" :key="category.name">
            <MenuCategory :category="category" @add-item="$emit('add-item', $event)" />
        </div>
    </div>
</template>
