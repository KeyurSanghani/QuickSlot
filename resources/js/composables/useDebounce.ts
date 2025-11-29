import { ref, watch, type Ref } from 'vue';

export interface DebounceOptions {
    delay?: number;
    immediate?: boolean;
}

/**
 * Creates a debounced version of a reactive value
 * @param value - The reactive value to debounce
 * @param delay - Delay in milliseconds (default: 300ms)
 * @param immediate - Whether to trigger immediately on first change (default: false)
 * @returns Debounced reactive value
 */
export function useDebounce<T>(value: Ref<T>, delay: number = 300, immediate: boolean = false): Ref<T> {
    const debouncedValue = ref(value.value) as Ref<T>;
    let timeout: ReturnType<typeof setTimeout> | null = null;

    watch(
        value,
        (newValue) => {
            if (immediate && !timeout) {
                debouncedValue.value = newValue;
                immediate = false;
                return;
            }

            if (timeout) {
                clearTimeout(timeout);
            }

            timeout = setTimeout(() => {
                debouncedValue.value = newValue;
                timeout = null;
            }, delay);
        },
        { immediate: false },
    );

    return debouncedValue;
}

/**
 * Creates a debounced function
 * @param fn - Function to debounce
 * @param delay - Delay in milliseconds (default: 300ms)
 * @returns Debounced function
 */
export function useDebouncedFunction<T extends (...args: any[]) => any>(fn: T, delay: number = 300): T {
    let timeout: ReturnType<typeof setTimeout> | null = null;

    return ((...args: Parameters<T>) => {
        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            fn(...args);
            timeout = null;
        }, delay);
    }) as T;
}
