import { ref } from 'vue'

export function useBookingForm() {
    const loading = ref(false)
    const errors = ref<Record<string, string[]>>({})

    const setLoading = (value: boolean) => {
        loading.value = value
    }

    const setErrors = (validationErrors: Record<string, string[]>) => {
        errors.value = validationErrors
    }

    const clearErrors = () => {
        errors.value = {}
    }

    const getError = (field: string): string | undefined => {
        return errors.value[field]?.[0]
    }

    const hasError = (field: string): boolean => {
        return !!errors.value[field]
    }

    return {
        loading,
        errors,
        setLoading,
        setErrors,
        clearErrors,
        getError,
        hasError,
    }
}
