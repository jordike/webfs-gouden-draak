import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { ZiggyVue } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const messages = Object.fromEntries(
            Object.entries(import.meta.glob('../../lang/*.json', { eager: true })).map(([key, value]: [string, any]) => {
                const match = /\/([a-zA-Z-_]+)\.json$/.exec(key);
                const locale = match ? match[1] : undefined;

                return [locale, value.default ?? value];
            }),
        );

        const i18n = createI18n({
            locale: (props.initialPage.props.locale as string) || 'nl',
            fallbackLocale: 'nl',
            messages,
        });

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
