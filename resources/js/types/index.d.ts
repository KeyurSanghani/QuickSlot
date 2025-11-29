import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

// Base interfaces for common fields
export interface BaseModel {
    id: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string | null;
}

export interface AuditableModel extends BaseModel {
    created_by?: number | null;
    updated_by?: number | null;
}

// User related interfaces
export interface User extends AuditableModel {
    first_name: string;
    last_name: string;
    full_name: string;
    name: string; // Alias for full_name
    email: string;
    contact_no?: string | null;
    profile_picture?: string | null;
    profile_thumbnail?: string | null;
    status: number;
    email_verified_at?: string | null;
    role?: string;
    role_slug?: string;
}

// Role interface
export interface Role extends BaseModel {
    name: string;
    guard_name: string;
    permissions?: Permission[];
}

// Permission interface
export interface Permission extends BaseModel {
    name: string;
    guard_name: string;
}

// Auth interface
export interface Auth {
    user: User;
    permissions?: string[];
    roles?: string[];
}

// Navigation interfaces
export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

// Page props type
export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

// Type aliases for backward compatibility
export type BreadcrumbItemType = BreadcrumbItem;

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

export interface PaginationMeta {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
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
    slug?: string; // Optional slug field for roles
}

export interface RoleOption extends SelectOption {
    slug: string; // Required slug field for roles
}

export interface FilterOptions {
    search?: string;
    status?: 'active' | 'inactive' | 'all';
    sort_by?: string;
    sort_direction?: 'asc' | 'desc';
    per_page?: number;
    page?: number;
}
