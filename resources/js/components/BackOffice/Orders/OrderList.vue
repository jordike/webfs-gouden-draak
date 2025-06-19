<script lang="ts" setup>
    import { defineEmits, defineProps } from 'vue';
    import OrderItemCard from './OrderItemCard.vue';

    defineProps<{
        orderItems: Array<any>;
    }>();

    defineEmits(['increase', 'decrease', 'remove']);
</script>

<template>
    <ul class="mb-0 flex-1 space-y-2 overflow-y-auto pr-2" style="min-height: 0">
        <OrderItemCard
            v-for="(orderItem, idx) in orderItems"
            :key="orderItem.id"
            :orderItem="orderItem"
            :idx="idx"
            @increase="$emit('increase', idx)"
            @decrease="$emit('decrease', idx)"
            @remove="$emit('remove', idx)"
        />
    </ul>
</template>
