/**
 * Common model types for the application
 *
 * This file re-exports commonly used types from the main types file
 * for easier importing throughout the application.
 */

export type {
    // App types
    AppPageProps,
    AuditableModel,
    // Auth and permission types
    Auth,
    // Base model types
    BaseModel,
    // Navigation types
    BreadcrumbItem,
    NavItem,
    Permission,
    Role,
    // User related types
    User,
} from '@/types';

// Additional utility types for common operations
export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    links: {
        first: string | null;
        last: string | null;
        prev: string | null;
        next: string | null;
    };
}

export interface ApiResponse<T = any> {
    success: boolean;
    message: string;
    data?: T;
    errors?: Record<string, string[]>;
}

export interface SelectOption {
    label: string;
    value: string | number;
    disabled?: boolean;
}

export interface FilterOptions {
    search?: string;
    status?: 'active' | 'inactive' | 'all';
    sort_by?: string;
    sort_direction?: 'asc' | 'desc';
    per_page?: number;
    page?: number;
}
