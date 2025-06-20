<script lang="ts" setup>
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <div class="flex w-1/3 flex-row justify-center">
        <img class="h-[50px]" src="/assets/img/dragon-small.png" alt="Dragon Small" />

        <h1 class="my-[auto] h-[fit-content] font-[chinese] text-[30px] text-[yellow]">
            {{ t('restaurant_name') }}
        </h1>

        <img class="h-[50px]" src="/assets/img/dragon-small-flipped.png" alt="Dragon Small Flipped" />
    </div>
</template>
