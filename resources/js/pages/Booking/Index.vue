<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import { serviceService } from '@/services/serviceService'
import { availabilityService } from '@/services/availabilityService'
import { bookingService } from '@/services/bookingService'
import { useBookingForm } from '@/composables/useBookingForm'
import { useToast } from '@/composables/useToast'
import type { Service, TimeSlot, BookingFormData } from '@/types/booking'
import ServiceSelection from '@/components/booking/ServiceSelection.vue'
import DatePicker from '@/components/booking/DatePicker.vue'
import TimeSlotSelection from '@/components/booking/TimeSlotSelection.vue'
import BookingForm from '@/components/booking/BookingForm.vue'
import FlashMessage from '@/components/FlashMessage.vue'

defineProps<{
    title: string
}>()

const { success: showSuccess, error: showError } = useToast()
const { loading, setLoading, errors, setErrors, clearErrors } = useBookingForm()

// State
const services = ref<Service[]>([])
const selectedService = ref<Service | null>(null)
const selectedDate = ref<string>('')
const selectedTime = ref<string>('')
const selectedSlot = ref<TimeSlot | null>(null)
const availableSlots = ref<TimeSlot[]>([])
const step = ref<number>(1)

// Load active services
onMounted(async () => {
    try {
        setLoading(true)
        const response = await serviceService.getActive()
        services.value = response.data
    } catch (error: any) {
        showError(error.response?.data?.message || 'Failed to load services')
    } finally {
        setLoading(false)
    }
})

// Handle service selection
const handleServiceSelect = (service: Service) => {
    selectedService.value = service
    selectedDate.value = ''
    selectedTime.value = ''
    selectedSlot.value = null
    availableSlots.value = []
    step.value = 2
}

// Handle date selection
const handleDateSelect = async (date: string) => {
    if (!selectedService.value) return

    selectedDate.value = date
    selectedTime.value = ''

    try {
        setLoading(true)
        const response = await availabilityService.getAvailableSlots(date, selectedService.value.id)
        availableSlots.value = response.data
        step.value = 3
    } catch (error: any) {
        showError(error.response?.data?.message || 'Failed to load available slots')
    } finally {
        setLoading(false)
    }
}

// Handle time selection
const handleTimeSelect = (time: string) => {
    selectedTime.value = time
    // Find the full slot object to get the start_time
    selectedSlot.value = availableSlots.value.find(slot => slot.time === time) || null
    step.value = 4
}

// Handle booking submission
const handleBookingSubmit = async (formData: BookingFormData) => {
    if (!selectedService.value || !selectedDate.value || !selectedSlot.value) return

    try {
        setLoading(true)
        clearErrors()

        // Ensure start_time is in HH:MM format
        const startTime = selectedSlot.value.start_time.substring(0, 5)

        const bookingData: BookingFormData = {
            ...formData,
            service_id: selectedService.value.id,
            booking_date: selectedDate.value,
            start_time: startTime,
        }

        await bookingService.create(bookingData)
        showSuccess('Booking created successfully! A confirmation email has been sent.')

        // Reset form
        resetForm()
    } catch (error: any) {
        if (error.response?.status === 422) {
            setErrors(error.response.data.errors || {})
        } else if (error.response?.status === 409) {
            showError('This time slot is no longer available. Please select another time.')
            // Reload available slots
            if (selectedDate.value && selectedService.value) {
                handleDateSelect(selectedDate.value)
            }
        } else {
            showError(error.response?.data?.message || 'Failed to create booking')
        }
    } finally {
        setLoading(false)
    }
}

// Reset form
const resetForm = () => {
    selectedService.value = null
    selectedDate.value = ''
    selectedTime.value = ''
    selectedSlot.value = null
    availableSlots.value = []
    step.value = 1
    clearErrors()
}

// Go back to previous step
const goBack = () => {
    if (step.value > 1) {
        step.value--
        if (step.value === 1) {
            selectedService.value = null
        } else if (step.value === 2) {
            selectedDate.value = ''
            availableSlots.value = []
        } else if (step.value === 3) {
            selectedTime.value = ''
            selectedSlot.value = null
        }
    }
}
</script>

<template>
    <Head :title="title" />

    <!-- Flash Message Toast -->
    <FlashMessage />

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Book Your Appointment</h1>
                <p class="mt-2 text-lg text-gray-600">Choose a service, date, and time for your appointment</p>
            </div>

            <!-- Steps Indicator -->
            <div class="mt-8">
                <nav aria-label="Progress">
                    <ol role="list" class="flex items-center justify-center space-x-5">
                        <li v-for="(stepLabel, index) in ['Service', 'Date', 'Time', 'Details']" :key="index"
                            class="relative">
                            <div v-if="step > index + 1" class="flex items-center">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-white">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-indigo-600">{{ stepLabel }}</span>
                            </div>
                            <div v-else-if="step === index + 1" class="flex items-center">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-600 bg-white text-indigo-600">
                                    {{ index + 1 }}
                                </div>
                                <span class="ml-3 text-sm font-medium text-indigo-600">{{ stepLabel }}</span>
                            </div>
                            <div v-else class="flex items-center">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-300 bg-white text-gray-500">
                                    {{ index + 1 }}
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-500">{{ stepLabel }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Content -->
            <div class="mt-12">
                <!-- Step 1: Service Selection -->
                <ServiceSelection v-if="step === 1" :services="services" :loading="loading"
                    @select="handleServiceSelect" />

                <!-- Step 2: Date Selection -->
                <DatePicker v-if="step === 2 && selectedService" :service="selectedService" :loading="loading"
                    @select="handleDateSelect" @back="goBack" />

                <!-- Step 3: Time Slot Selection -->
                <TimeSlotSelection v-if="step === 3" :slots="availableSlots" :selectedTime="selectedTime"
                    :loading="loading" @select="handleTimeSelect" @back="goBack" />

                <!-- Step 4: Booking Form -->
                <BookingForm v-if="step === 4" :service="selectedService" :date="selectedDate" :time="selectedTime"
                    :loading="loading" :errors="errors" @submit="handleBookingSubmit" @back="goBack" />
            </div>
        </div>
    </div>
</template>
