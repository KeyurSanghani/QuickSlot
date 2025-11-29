import api from './api'
import type { ApiResponse, TimeSlot, AvailableDate } from '@/types/booking'

export const availabilityService = {
    /**
     * Get available time slots for a specific date and service
     */
    async getAvailableSlots(date: string, serviceId: string): Promise<ApiResponse<TimeSlot[]>> {
        const response = await api.get('/availability/slots', {
            params: {
                date,
                service_id: serviceId,
            },
        })
        return response.data
    },

    /**
     * Get available dates within a date range for a service
     */
    async getAvailableDates(
        serviceId: string,
        startDate: string,
        endDate: string
    ): Promise<ApiResponse<AvailableDate[]>> {
        const response = await api.get('/availability/dates', {
            params: {
                service_id: serviceId,
                start_date: startDate,
                end_date: endDate,
            },
        })
        return response.data
    },
}
