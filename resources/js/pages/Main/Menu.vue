<script lang="ts" setup>
    import AppLayout from '@/layouts/AppLayout.vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <AppLayout>
        <a
            href="/menu/download"
            target="_blank"
            class="mb-3 block w-[fit-content] border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]"
        >
            {{ t('main.menu.download_current_menu') }}
        </a>

        <img src="/assets/img/menu/menu-top.jpg" alt="Menu top" />
        <img src="/assets/img/menu/menu-bottom.jpg" alt="Menu bottom" />
    </AppLayout>
</template>
