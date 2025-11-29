import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useQueryParams() {
    const page = usePage();

    const queryParams = computed(() => {
        const url = page.url;
        const queryString = url.split('?')[1];

        if (!queryString) return {};

        return Object.fromEntries(new URLSearchParams(queryString));
    });

    const getParam = (key: string, defaultValue: any = null) => {
        return queryParams.value[key] || defaultValue;
    };

    const hasParam = (key: string) => {
        return key in queryParams.value;
    };

    const updateParam = (key: string, value: string | null, replace: boolean = true) => {
        const currentUrl = new URL(window.location.href);
        const searchParams = new URLSearchParams(currentUrl.search);

        if (value === null || value === '') {
            searchParams.delete(key);
        } else {
            searchParams.set(key, value);
        }

        const newUrl = `${currentUrl.pathname}${searchParams.toString() ? '?' + searchParams.toString() : ''}`;

        if (replace) {
            window.history.replaceState({}, '', newUrl);
        } else {
            window.history.pushState({}, '', newUrl);
        }
    };

    const updateParams = (params: Record<string, string | null>, replace: boolean = true) => {
        const currentUrl = new URL(window.location.href);
        const searchParams = new URLSearchParams(currentUrl.search);

        Object.entries(params).forEach(([key, value]) => {
            if (value === null || value === '') {
                searchParams.delete(key);
            } else {
                searchParams.set(key, value);
            }
        });

        const newUrl = `${currentUrl.pathname}${searchParams.toString() ? '?' + searchParams.toString() : ''}`;

        if (replace) {
            window.history.replaceState({}, '', newUrl);
        } else {
            window.history.pushState({}, '', newUrl);
        }
    };

    return {
        queryParams: queryParams,
        getParam,
        hasParam,
        updateParam,
        updateParams,
    };
}
