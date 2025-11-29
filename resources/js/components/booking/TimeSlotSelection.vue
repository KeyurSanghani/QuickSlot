<script setup lang="ts">
import type { TimeSlot } from '@/types/booking'

defineProps<{
    slots: TimeSlot[]
    selectedTime: string
    loading: boolean
}>()

const emit = defineEmits<{
    select: [time: string]
    back: []
}>()
</script>

<template>
    <div class="mx-auto max-w-4xl">
        <button @click="emit('back')" class="mb-6 flex items-center text-indigo-600 hover:text-indigo-700">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </button>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Select a Time</h2>
            <p class="text-gray-600 mb-6">Choose an available time slot</p>

            <div v-if="loading" class="grid grid-cols-3 gap-4 sm:grid-cols-4 lg:grid-cols-6">
                <div v-for="i in 12" :key="i" class="h-12 bg-gray-200 rounded animate-pulse"></div>
            </div>

            <div v-else-if="slots.length === 0" class="text-center py-12">
                <p class="text-gray-500">No available time slots for this date.</p>
            </div>

            <div v-else class="grid grid-cols-3 gap-4 sm:grid-cols-4 lg:grid-cols-6">
                <button v-for="slot in slots" :key="slot.time" @click="slot.available && emit('select', slot.time)"
                    :disabled="!slot.available" :class="[
                        'rounded-lg border-2 py-3 px-4 text-sm font-medium transition-colors',
                        !slot.available
                            ? 'border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed'
                            : selectedTime === slot.time
                                ? 'border-indigo-600 bg-indigo-600 text-white'
                                : 'border-gray-300 bg-white text-gray-900 hover:border-indigo-600 hover:bg-indigo-50'
                    ]">
                    {{ slot.time }}
                </button>
            </div>
        </div>
    </div>
</template>
