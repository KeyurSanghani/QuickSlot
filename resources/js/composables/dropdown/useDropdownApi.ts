import type { DropdownType, Status } from '@/constants/enums';
import { DROPDOWN_TYPES } from '@/constants/enums';
import api from '@/lib/axios';
import { ref } from 'vue';

export interface DropdownOption {
    label: string;
    value: string | number;
}

export interface DropdownParams {
    type: DropdownType;
    is_decrypted?: boolean;
    status?: Status;
}

export interface ApiResponse<T> {
    status: boolean;
    message: string;
    data: T;
}

export const useDropdownApi = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);

    /**
     * Fetch dropdown options based on type and optional parameters
     *
     * @param params - The dropdown parameters
     * @returns Promise with dropdown options array or null if error
     */
    const getDropdown = async (params: DropdownParams): Promise<DropdownOption[] | null> => {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.get<ApiResponse<DropdownOption[]>>('/dropdown', {
                params: {
                    type: params.type,
                    status: params.status,
                },
            });

            if (response.data.status) {
                return response.data.data;
            } else {
                error.value = response.data.message;
                return null;
            }
        } catch (err: any) {
            if (err.response?.data?.message) {
                error.value = err.response.data.message;
            } else {
                error.value = err.message || 'An error occurred while fetching dropdown data';
            }
            return null;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        // State
        isLoading,
        error,

        // Methods
        getDropdown,

        // Constants
        DROPDOWN_TYPES,
    };
};
