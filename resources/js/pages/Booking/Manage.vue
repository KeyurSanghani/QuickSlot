<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { bookingService } from '@/services/bookingService'
import { serviceService } from '@/services/serviceService'
import { useToast } from '@/composables/useToast'
import type { Booking, PaginatedResponse, PaginationMeta, Service } from '@/types/booking'
import BookingTable from '@/components/booking/BookingTable.vue'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Label } from '@/components/ui/label'

defineProps<{
    title: string
}>()

const { success, error: showError } = useToast()
const loading = ref(false)
const bookings = ref<Booking[]>([])
const services = ref<Service[]>([])
const selectedService = ref<string>('all')
const selectedStatus = ref<string>('all')
const isInitialLoad = ref(true)

const pagination = ref<PaginationMeta>({
    current_page: 1,
    next_page: null,
    from: 0,
    last_page: 1,
    per_page: 15,
    to: 0,
    total: 0,
})

const loadServices = async () => {
    try {
        const response = await serviceService.getActive()
        services.value = response.data
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to load services')
    }
}

const loadBookings = async (page: number = 1) => {
    try {
        loading.value = true
        
        const statusParam = selectedStatus.value === 'all' ? null : selectedStatus.value
        const serviceParam = selectedService.value === 'all' ? null : selectedService.value
        
        console.log('Loading bookings with filters:', {
            page,
            perPage: pagination.value.per_page,
            status: statusParam,
            serviceId: serviceParam
        })
        
        const response = await bookingService.getAll(
            pagination.value.per_page,
            page,
            statusParam,
            serviceParam
        )
        const data = response.data as PaginatedResponse<Booking>
        bookings.value = data.list
        pagination.value = data.pagination
        
        console.log('Bookings loaded:', data.list.length, 'items')
    } catch (err: any) {
        console.error('Error loading bookings:', err)
        showError(err.response?.data?.message || 'Failed to load bookings')
    } finally {
        loading.value = false
    }
}

const handleConfirm = async (id: string) => {
    try {
        await bookingService.confirm(id)
        success('Booking confirmed successfully')
        loadBookings(pagination.value.current_page)
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to confirm booking')
    }
}

const handleCancel = async (id: string, reason?: string) => {
    try {
        await bookingService.cancel(id, reason)
        success('Booking cancelled successfully')
        loadBookings(pagination.value.current_page)
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to cancel booking')
    }
}

const handleComplete = async (id: string) => {
    try {
        await bookingService.complete(id)
        success('Booking marked as completed')
        loadBookings(pagination.value.current_page)
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to complete booking')
    }
}

const handleDelete = async (id: string) => {
    try {
        await bookingService.delete(id)
        success('Booking deleted successfully')
        loadBookings(pagination.value.current_page)
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to delete booking')
    }
}

const handlePerPageChange = async (perPage: number) => {
    pagination.value.per_page = perPage
    loadBookings(1)
}

// Watch for filter changes
watch([selectedService, selectedStatus], () => {
    // Skip the initial watch trigger
    if (isInitialLoad.value) {
        isInitialLoad.value = false
        return
    }
    
    console.log('Filters changed - Service:', selectedService.value, 'Status:', selectedStatus.value)
    loadBookings(1)
})

onMounted(async () => {
    await loadServices()
    await loadBookings()
    // Allow watch to work after initial load
    isInitialLoad.value = false
})
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Manage Bookings</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage all bookings</p>
            </div>

            <!-- Filters Section -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Filter Bookings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Service Filter -->
                    <div class="space-y-2">
                        <Label for="service-filter" class="text-sm font-medium">Service</Label>
                        <Select v-model="selectedService">
                            <SelectTrigger id="service-filter">
                                <SelectValue placeholder="All Services" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">All Services</SelectItem>
                                <SelectItem 
                                    v-for="service in services" 
                                    :key="service.id" 
                                    :value="service.id"
                                >
                                    {{ service.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-2">
                        <Label for="status-filter" class="text-sm font-medium">Status</Label>
                        <Select v-model="selectedStatus">
                            <SelectTrigger id="status-filter">
                                <SelectValue placeholder="All Status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">All Status</SelectItem>
                                <SelectItem value="pending">Pending</SelectItem>
                                <SelectItem value="confirmed">Confirmed</SelectItem>
                                <SelectItem value="completed">Completed</SelectItem>
                                <SelectItem value="cancelled">Cancelled</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </div>

            <BookingTable 
                :bookings="bookings" 
                :loading="loading" 
                :pagination="pagination"
                @confirm="handleConfirm"
                @cancel="handleCancel"
                @complete="handleComplete"
                @delete="handleDelete"
                @page-change="loadBookings"
                @change-per-page="handlePerPageChange"
            />
        </div>
    </AppLayout>
</template>
