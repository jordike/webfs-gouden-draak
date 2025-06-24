<script lang="ts" setup>
    import { Link } from '@inertiajs/vue3';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <div class="flex flex-row justify-between">
        <img class="h-[200px]" src="/assets/img/dragon-small.png" alt="Golden Dragon" />

        <section>
            <h1 class="mb-3 text-center text-[40px] font-bold text-[#ffff00]">
                {{ t('main.header.title') }} <br />
                <span class="text-[50px]">{{ t('restaurant_name') }}</span>
            </h1>

            <nav class="flex flex-row justify-center gap-[3px]">
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/menukaart">
                    {{ t('main.navbar.menu_card') }}
                </Link>
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/nieuws">
                    {{ t('main.navbar.news') }}
                </Link>
                <Link class="border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px]" href="/contact">
                    {{ t('main.navbar.contact') }}
                </Link>
            </nav>

            <div class="mt-4 flex justify-center gap-2">
                <button
                    :class="[
                        'border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px] font-medium transition-colors',
                        $i18n.locale === 'nl' ? 'opacity-100' : 'text-white opacity-70 hover:opacity-100',
                    ]"
                    @click="$i18n.locale = 'nl'"
                >
                    NL
                </button>
                <button
                    :class="[
                        'border-1 border-white bg-[url(/assets/img/menu_bg_gradient.png)] px-[10px] font-medium transition-colors',
                        $i18n.locale === 'en' ? 'opacity-100' : 'text-white opacity-70 hover:opacity-100',
                    ]"
                    @click="$i18n.locale = 'en'"
                >
                    EN
                </button>
            </div>
        </section>

        <img class="h-[200px]" src="/assets/img/dragon-small-flipped.png" alt="Golden Dragon Flipped" />
    </div>
</template>
