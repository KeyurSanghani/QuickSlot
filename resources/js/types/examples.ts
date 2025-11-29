/**
 * Example usage of common types throughout the application
 *
 * This file demonstrates how to import and use the centralized types
 * in different parts of your application.
 */

// ===== IMPORTING TYPES =====

// Import from main types file
import type { ApiResponse, BreadcrumbItem, PaginatedResponse, PaginationMeta, SelectOption, User, UserFormData } from '@/types';

// Or import from the models file for commonly used types
// import type {
//     User as UserModel,
//     Company as CompanyModel
// } from '@/types/models'

// ===== COMPONENT USAGE EXAMPLES =====

// In a Vue component for user management
export interface UserPageProps {
    user?: User;
    users?: PaginatedResponse<User>;
    roles?: SelectOption[];
}

// In a form component
export interface UserFormProps {
    user?: UserFormData;
    isEdit?: boolean;
    isLoading?: boolean;
    onSubmit?: (data: UserFormData) => void;
}

// ===== API COMPOSABLE EXAMPLES =====

// In an API composable
export const useUserApi = () => {
    const createUser = async (data: UserFormData): Promise<ApiResponse<User>> => {
        // API call implementation
        return { success: true, message: 'User created', data: {} as User };
    };

    const getUsers = async (): Promise<ApiResponse<PaginatedResponse<User>>> => {
        // API call implementation
        return { success: true, message: 'Users fetched', data: {} as PaginatedResponse<User> };
    };

    return { createUser, getUsers };
};

// ===== UTILITY FUNCTION EXAMPLES =====

// Helper function to format user name
export const formatUserName = (user: User): string => {
    return user.full_name || `${user.first_name} ${user.last_name}`;
};

// Helper function to check if user is active
export const isUserActive = (user: User): boolean => {
    return user.status === 1;
};

// Helper function to transform user to form data
export const userToFormData = (user: User): UserFormData => {
    return {
        first_name: user.first_name,
        last_name: user.last_name,
        email: user.email,
        contact_no: user.contact_no || '',
        role: '', // Would need to be set based on user roles
        status: user.status === 1,
        company_id: user.company_id || undefined,
    };
};

// ===== STORE/STATE MANAGEMENT EXAMPLES =====

// In a Pinia store
export interface UserStore {
    users: User[];
    currentUser: User | null;
    isLoading: boolean;
    pagination: PaginationMeta | null;
}

// ===== BREADCRUMB HELPERS =====

export const createUserBreadcrumbs = (userId?: string | number): BreadcrumbItem[] => [
    { title: 'Dashboard', href: '/' },
    { title: 'Users', href: '/users' },
    ...(userId ? [{ title: 'Edit User', href: `/users/${userId}/edit` }] : []),
];

export const createCompanyBreadcrumbs = (companyId?: string | number): BreadcrumbItem[] => [
    { title: 'Dashboard', href: '/' },
    { title: 'Companies', href: route('companies.index') },
    ...(companyId ? [{ title: 'Edit Company', href: `/companies/${companyId}/edit` }] : []),
];
