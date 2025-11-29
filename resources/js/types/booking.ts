export interface Service {
    id: string
    name: string
    description: string | null
    duration: number
    price: number
    is_active: boolean
    created_at: string
    updated_at: string
}

export interface WorkingHour {
    id: string
    day_of_week: number
    day_name: string
    start_time: string
    end_time: string
    is_active: boolean
    created_at: string
    updated_at: string
}

export enum BookingStatus {
    PENDING = 'pending',
    CONFIRMED = 'confirmed',
    CANCELLED = 'cancelled',
    COMPLETED = 'completed',
}

export interface Booking {
    id: string
    service_id: string
    service: Service
    client_name: string
    client_email: string
    client_phone: string | null
    booking_date: string
    start_time: string
    end_time: string
    status: BookingStatus
    status_label: string
    notes: string | null
    cancellation_reason: string | null
    cancelled_at: string | null
    created_at: string
    updated_at: string
}

export interface TimeSlot {
    time: string
    available: boolean
    start_time: string
    end_time: string
    display_time: string
}

export interface AvailableDate {
    date: string
    has_slots: boolean
}

export interface PaginationMeta {
    current_page: number
    next_page: number | null
    from: number
    last_page: number
    per_page: number
    to: number
    total: number
}

export interface PaginatedResponse<T> {
    list: T[]
    pagination: PaginationMeta
}

export interface ApiResponse<T = any> {
    status: boolean
    data: T
    message: string
}

export interface BookingFormData {
    service_id: string
    client_name: string
    client_email: string
    client_phone?: string
    booking_date: string
    start_time: string
    end_time?: string
    notes?: string
}

export interface ServiceFormData {
    name: string
    description?: string
    duration: number
    price: number
    is_active?: boolean
}

export interface WorkingHourFormData {
    day_of_week: number
    start_time: string
    end_time: string
    is_active?: boolean
}
