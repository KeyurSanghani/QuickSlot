<script setup lang="ts">
import { reactive } from 'vue'
import type { Service, BookingFormData } from '@/types/booking'

const props = defineProps<{
    service: Service | null
    date: string
    time: string
    loading: boolean
    errors: Record<string, string[]>
}>()

const emit = defineEmits<{
    submit: [formData: BookingFormData]
    back: []
}>()

const form = reactive({
    client_name: '',
    client_email: '',
    client_phone: '',
    notes: '',
})

const handleSubmit = () => {
    emit('submit', {
        service_id: props.service?.id || '',
        booking_date: props.date,
        start_time: props.time,
        ...form,
    })
}

const getError = (field: string): string | undefined => {
    return props.errors[field]?.[0]
}
</script>

<template>
    <div class="mx-auto max-w-2xl">
        <button @click="emit('back')" class="mb-6 flex items-center text-indigo-600 hover:text-indigo-700">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </button>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Enter Your Details</h2>
            <p class="text-gray-600 mb-6">Please provide your contact information</p>

            <!-- Booking Summary -->
            <div class="mb-6 rounded-lg bg-gray-50 p-4">
                <h3 class="font-semibold text-gray-900 mb-3 text-base">Booking Summary</h3>
                <div class="space-y-2 text-base">
                    <p class="text-gray-900"><span class="font-semibold text-black">Service:</span> <span class="text-black">{{ service?.name }}</span></p>
                    <p class="text-gray-900"><span class="font-semibold text-black">Date:</span> <span class="text-black">{{ date }}</span></p>
                    <p class="text-gray-900"><span class="font-semibold text-black">Time:</span> <span class="text-black">{{ time }}</span></p>
                    <p class="text-gray-900"><span class="font-semibold text-black">Duration:</span> <span class="text-black">{{ service?.duration }} minutes</span></p>
                    <p class="text-gray-900"><span class="font-semibold text-black">Price:</span> <span class="text-black">${{ service?.price }}</span></p>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="handleSubmit" class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input v-model="form.client_name" type="text" id="client_name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base text-black py-3 px-4"
                        :class="{ 'border-red-500': getError('client_name') }" />
                    <p v-if="getError('client_name')" class="mt-1 text-sm text-red-600">{{ getError('client_name') }}
                    </p>
                </div>

                <!-- Email -->
                <div>
                    <label for="client_email" class="block text-sm font-medium text-gray-700">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input v-model="form.client_email" type="email" id="client_email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base text-black py-3 px-4"
                        :class="{ 'border-red-500': getError('client_email') }" />
                    <p v-if="getError('client_email')" class="mt-1 text-sm text-red-600">{{ getError('client_email') }}
                    </p>
                </div>

                <!-- Phone -->
                <div>
                    <label for="client_phone" class="block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>
                    <input v-model="form.client_phone" type="tel" id="client_phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base text-black py-3 px-4"
                        :class="{ 'border-red-500': getError('client_phone') }" />
                    <p v-if="getError('client_phone')" class="mt-1 text-sm text-red-600">{{ getError('client_phone') }}
                    </p>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        Additional Notes
                    </label>
                    <textarea v-model="form.notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base text-black py-3 px-4"
                        :class="{ 'border-red-500': getError('notes') }" />
                    <p v-if="getError('notes')" class="mt-1 text-sm text-red-600">{{ getError('notes') }}</p>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" :disabled="loading" :class="[
                        'rounded-md px-6 py-3 text-sm font-semibold text-white shadow-sm',
                        loading
                            ? 'bg-indigo-400 cursor-not-allowed'
                            : 'bg-indigo-600 hover:bg-indigo-700'
                    ]">
                        <span v-if="loading">Processing...</span>
                        <span v-else>Confirm Booking</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
