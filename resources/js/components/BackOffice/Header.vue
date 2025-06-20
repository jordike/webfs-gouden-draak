<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <header class="flex items-center justify-between bg-gradient-to-r from-[#bfa14a] to-[#fffbe6] px-8 py-3 shadow-md">
        <div class="flex items-center">
            <img src="/assets/img/dragon-small.png" alt="Gouden Draak Logo" class="mr-4 h-10" />
            <h1 class="m-0 text-2xl font-bold text-[#7c5c13]">{{ t('backoffice.header.title') }}</h1>
        </div>

        <nav class="flex gap-6">
            <Link href="/backoffice/orders" class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]">
                {{ t('backoffice.header.kassa') }}
            </Link>
            <Link href="/backoffice/menu" class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]">
                {{ t('backoffice.header.menu') }}
            </Link>
            <Link href="/backoffice/sales" class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]">
                {{ t('backoffice.header.sales_overview') }}
            </Link>
            <Link href="/backoffice/reviews" class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]">
                {{ t('backoffice.header.reviews') }}
            </Link>
            <Link
                href="/backoffice/sales/daily-overview"
                class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]"
            >
                {{ t('backoffice.header.daily_overview') }}
            </Link>
            <Link href="/backoffice/tables" class="text-lg font-medium text-[#7c5c13] no-underline transition-colors hover:text-[#bfa14a]">
                {{ t('backoffice.header.tables') }}
            </Link>
        </nav>

        <div class="ml-8">
            <Link
                href="/logout"
                method="post"
                as="button"
                class="cursor-pointer rounded bg-[#bfa14a] px-5 py-2 font-bold text-white no-underline transition-colors hover:bg-[#7c5c13]"
            >
                {{ t('backoffice.header.logout') }}
            </Link>
        </div>
    </header>
</template>
