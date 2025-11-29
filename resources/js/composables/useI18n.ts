import en, { type Translations } from '@/lang/en';
import { computed, ref } from 'vue';

/**
 * Simple i18n composable for multilingual support
 *
 * This provides a basic translation system that can be extended
 * to support multiple languages in the future.
 *
 * @example
 * const { t } = useI18n()
 * const title = t('custom_field_definition.title')
 * const message = t('common.showing_results', { from: 1, to: 10, total: 100 })
 */

// Current locale (can be extended to support multiple languages)
const locale = ref<'en'>('en');

// Translation dictionaries
const translations: Record<string, Translations> = {
    en,
};

/**
 * Get nested value from object using dot notation
 *
 * @param obj - The object to search
 * @param path - The dot-notation path (e.g., 'common.actions')
 * @returns The value at the path or the path itself if not found
 */
function getNestedValue(obj: any, path: string): string {
    return path.split('.').reduce((current, key) => current?.[key], obj) ?? path;
}

/**
 * Replace placeholders in a string with provided values
 *
 * @param str - The string with placeholders (e.g., 'Hello {name}')
 * @param params - The values to replace (e.g., { name: 'John' })
 * @returns The string with replaced values
 */
function replacePlaceholders(str: string, params?: Record<string, any>): string {
    if (!params) return str;

    return Object.keys(params).reduce((result, key) => {
        return result.replace(new RegExp(`{${key}}`, 'g'), String(params[key]));
    }, str);
}

export function useI18n() {
    /**
     * Translate a key to the current locale
     *
     * @param key - The translation key in dot notation
     * @param params - Optional parameters for placeholder replacement
     * @returns The translated string
     *
     * @example
     * t('common.actions') // => 'Actions'
     * t('common.showing_results', { from: 1, to: 10, total: 100 })
     */
    const t = (key: string, params?: Record<string, any>): string => {
        const translation = getNestedValue(translations[locale.value], key);
        return replacePlaceholders(translation, params);
    };

    /**
     * Get the current locale
     */
    const currentLocale = computed(() => locale.value);

    /**
     * Change the current locale
     *
     * @param newLocale - The new locale to set
     */
    const setLocale = (newLocale: 'en') => {
        locale.value = newLocale;
    };

    /**
     * Check if a translation key exists
     *
     * @param key - The translation key to check
     * @returns True if the key exists, false otherwise
     */
    const hasTranslation = (key: string): boolean => {
        const translation = getNestedValue(translations[locale.value], key);
        return translation !== key;
    };

    return {
        t,
        currentLocale,
        setLocale,
        hasTranslation,
    };
}

// Export default instance for global usage
export default useI18n;
