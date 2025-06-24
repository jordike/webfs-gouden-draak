<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { useI18n } from 'vue-i18n';

    const { t } = useI18n();
</script>

<template>
    <AppLayout>
        <section class="p- mx-[50px] border-1 border-black bg-white p-[5px] text-center font-bold text-black">
            <p class="mb-[20px]" v-html="t('main.home.intro')"></p>
            <h3 class="mb-3 text-[20px] underline">
                {{ t('main.home.student_offer_title') }}
            </h3>
            <h4 class="text-[30px]">
                {{ t('main.home.student_offer_subtitle') }}
            </h4>
            <p>
                {{ t('main.home.student_offer_instruction') }}
            </p>

            <div class="my-6 flex flex-col items-center">
                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">
                        {{ t('main.home.dishes.koe_loe_yuk') }}
                    </span>
                    <span class="w-80 text-left">
                        {{ t('main.home.dishes.foe_yong_hai') }}
                    </span>
                </div>

                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">
                        {{ t('main.home.dishes.tjap_tjoy') }}
                    </span>
                    <span class="w-80 text-left">
                        {{ t('main.home.dishes.garnalen_knoflook') }}
                    </span>
                </div>

                <div class="mb-2 flex flex-row justify-center gap-12">
                    <span class="w-80 text-right">
                        {{ t('main.home.dishes.babi_pangang') }}
                    </span>
                    <span class="w-80 text-left">
                        {{ t('main.home.dishes.kipfilet_bonensaus') }}
                    </span>
                </div>
            </div>

            <p class="mb-3">
                {{ t('main.home.with_rice') }}
            </p>
            <p class="text-[30px]">
                {{ t('main.home.price') }}
            </p>
        </section>
    </AppLayout>
</template>
