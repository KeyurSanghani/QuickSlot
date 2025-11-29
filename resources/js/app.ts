import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import axios from 'axios';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

// ✅ Configure Axios for Sanctum session-based auth
axios.defaults.withCredentials = true; // send session cookies
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Optional: automatically hit csrf-cookie before first state-changing request
async function initCsrf() {
    try {
        await axios.get('/sanctum/csrf-cookie');
    } catch (error) {
        console.error('Failed to initialize CSRF protection', error);
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // 🔑 Ensure CSRF is initialized before mounting
        initCsrf().finally(() => {
            vueApp.mount(el);
        });
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
