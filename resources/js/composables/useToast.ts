import { usePage } from '@inertiajs/vue3';

export type ToastType = 'success' | 'error' | 'warning' | 'info';

/**
 * Toast composable for programmatic toast messages
 *
 * This works by directly setting props on the Inertia page
 * which will be picked up by the FlashMessage component
 */
export const useToast = () => {
    const page = usePage();

    const toast = (message: string, type: ToastType = 'success') => {
        // Clear any existing flash messages first
        const props = page.props as any;
        props.success = null;
        props.error = null;
        props.warning = null;
        props.info = null;

        // Set the new flash message based on type
        if (type === 'success') {
            props.success = message;
        } else if (type === 'error') {
            props.error = message;
        } else if (type === 'warning') {
            props.warning = message;
        } else if (type === 'info') {
            props.info = message;
        }
    };

    const success = (message: string) => toast(message, 'success');
    const error = (message: string) => toast(message, 'error');
    const warning = (message: string) => toast(message, 'warning');
    const info = (message: string) => toast(message, 'info');

    return {
        toast,
        success,
        error,
        warning,
        info,
    };
};
