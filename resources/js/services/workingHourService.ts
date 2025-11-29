import api from './api'
import type {
    ApiResponse,
    PaginatedResponse,
    WorkingHour,
    WorkingHourFormData,
} from '@/types/booking'

export const workingHourService = {
    /**
     * Get all working hours with pagination
     */
    async getAll(perPage: number = 15): Promise<ApiResponse<PaginatedResponse<WorkingHour>>> {
        const response = await api.get('/working-hours', {
            params: { per_page: perPage },
        })
        return response.data
    },

    /**
     * Get working hours grouped by day
     */
    async getGroupedByDay(): Promise<ApiResponse<Record<number, WorkingHour[]>>> {
        const response = await api.get('/working-hours/grouped')
        return response.data
    },

    /**
     * Get a single working hour by ID
     */
    async getById(id: string): Promise<ApiResponse<WorkingHour>> {
        const response = await api.get(`/working-hours/${id}`)
        return response.data
    },

    /**
     * Create a new working hour
     */
    async create(data: WorkingHourFormData): Promise<ApiResponse<WorkingHour>> {
        const response = await api.post('/working-hours', data)
        return response.data
    },

    /**
     * Update an existing working hour
     */
    async update(id: string, data: Partial<WorkingHourFormData>): Promise<ApiResponse<WorkingHour>> {
        const response = await api.put(`/working-hours/${id}`, { id, ...data })
        return response.data
    },

    /**
     * Delete a working hour
     */
    async delete(id: string): Promise<ApiResponse<null>> {
        const response = await api.delete(`/working-hours/${id}`, { data: { id } })
        return response.data
    },

    /**
     * Toggle working hour status
     */
    async toggleStatus(id: string): Promise<ApiResponse<WorkingHour>> {
        const response = await api.patch(`/working-hours/${id}/status`, { id })
        return response.data
    },
}
