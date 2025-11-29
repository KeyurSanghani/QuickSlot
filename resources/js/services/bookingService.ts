import api from './api'
import type {
    ApiResponse,
    PaginatedResponse,
    Booking,
    BookingFormData,
} from '@/types/booking'

export const bookingService = {
    /**
     * Get all bookings with pagination
     */
    async getAll(
        perPage: number = 15, 
        page: number = 1, 
        status?: string | null,
        serviceId?: string | null
    ): Promise<ApiResponse<PaginatedResponse<Booking>>> {
        const response = await api.get('/bookings', {
            params: { 
                per_page: perPage, 
                page,
                ...(status && { status }),
                ...(serviceId && { service_id: serviceId }),
            },
        })
        return response.data
    },

    /**
     * Get upcoming bookings
     */
    async getUpcoming(limit: number = 10): Promise<ApiResponse<Booking[]>> {
        const response = await api.get('/bookings/upcoming', {
            params: { limit },
        })
        return response.data
    },

    /**
     * Get bookings by date
     */
    async getByDate(date: string): Promise<ApiResponse<Booking[]>> {
        const response = await api.get('/bookings/by-date', {
            params: { date },
        })
        return response.data
    },

    /**
     * Get a single booking by ID
     */
    async getById(id: string): Promise<ApiResponse<Booking>> {
        const response = await api.get(`/bookings/${id}`)
        return response.data
    },

    /**
     * Create a new booking
     */
    async create(data: BookingFormData): Promise<ApiResponse<Booking>> {
        const response = await api.post('/bookings', data)
        return response.data
    },

    /**
     * Update an existing booking
     */
    async update(id: string, data: Partial<BookingFormData>): Promise<ApiResponse<Booking>> {
        const response = await api.put(`/bookings/${id}`, { id, ...data })
        return response.data
    },

    /**
     * Cancel a booking
     */
    async cancel(id: string, cancellationReason?: string): Promise<ApiResponse<Booking>> {
        const response = await api.patch(`/bookings/${id}/cancel`, {
            id,
            cancellation_reason: cancellationReason,
        })
        return response.data
    },

    /**
     * Confirm a booking
     */
    async confirm(id: string): Promise<ApiResponse<Booking>> {
        const response = await api.patch(`/bookings/${id}/confirm`, { id })
        return response.data
    },

    /**
     * Complete a booking
     */
    async complete(id: string): Promise<ApiResponse<Booking>> {
        const response = await api.patch(`/bookings/${id}/complete`, { id })
        return response.data
    },

    /**
     * Delete a booking
     */
    async delete(id: string): Promise<ApiResponse<null>> {
        const response = await api.delete(`/bookings/${id}`, { data: { id } })
        return response.data
    },
}
