import api from './api'
import type {
    ApiResponse,
    PaginatedResponse,
    Service,
    ServiceFormData,
} from '@/types/booking'

export const serviceService = {
    /**
     * Get all services with pagination
     */
    async getAll(perPage: number = 15): Promise<ApiResponse<PaginatedResponse<Service>>> {
        const response = await api.get('/services', {
            params: { per_page: perPage },
        })
        return response.data
    },

    /**
     * Get active services only
     */
    async getActive(): Promise<ApiResponse<Service[]>> {
        const response = await api.get('/services/active')
        return response.data
    },

    /**
     * Get a single service by ID
     */
    async getById(id: string): Promise<ApiResponse<Service>> {
        const response = await api.get(`/services/${id}`)
        return response.data
    },

    /**
     * Create a new service
     */
    async create(data: ServiceFormData): Promise<ApiResponse<Service>> {
        const response = await api.post('/services', data)
        return response.data
    },

    /**
     * Update an existing service
     */
    async update(id: string, data: Partial<ServiceFormData>): Promise<ApiResponse<Service>> {
        const response = await api.put(`/services/${id}`, { id, ...data })
        return response.data
    },

    /**
     * Delete a service
     */
    async delete(id: string): Promise<ApiResponse<null>> {
        const response = await api.delete(`/services/${id}`, { data: { id } })
        return response.data
    },

    /**
     * Toggle service status
     */
    async toggleStatus(id: string): Promise<ApiResponse<Service>> {
        const response = await api.patch(`/services/${id}/status`, { id })
        return response.data
    },
}
