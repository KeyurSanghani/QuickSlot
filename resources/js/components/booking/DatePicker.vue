<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Service } from '@/types/booking'

defineProps<{
    service: Service
    loading: boolean
}>()

const emit = defineEmits<{
    select: [date: string]
    back: []
}>()

const selectedDate = ref<string>('')
const currentMonth = ref(new Date())

// Get days in month
const daysInMonth = computed(() => {
    const year = currentMonth.value.getFullYear()
    const month = currentMonth.value.getMonth()
    const lastDay = new Date(year, month + 1, 0)
    const days: Date[] = []

    for (let d = 1; d <= lastDay.getDate(); d++) {
        days.push(new Date(year, month, d))
    }

    return days
})

// Navigate months
const previousMonth = () => {
    currentMonth.value = new Date(currentMonth.value.getFullYear(), currentMonth.value.getMonth() - 1)
}

const nextMonth = () => {
    currentMonth.value = new Date(currentMonth.value.getFullYear(), currentMonth.value.getMonth() + 1)
}

// Check if date is in the past
const isPast = (date: Date): boolean => {
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    return date < today
}

// Format date for API
const formatDate = (date: Date): string => {
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()
    return `${day}-${month}-${year}`
}

// Handle date selection
const selectDate = (date: Date) => {
    if (isPast(date)) return
    selectedDate.value = formatDate(date)
    emit('select', selectedDate.value)
}

// Get month/year string
const monthYear = computed(() => {
    return currentMonth.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
})
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
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Select a Date</h2>
            <p class="text-gray-600 mb-6">Choose a date for your {{ service.name }} appointment</p>

            <!-- Calendar Header -->
            <div class="flex items-center justify-between mb-6 bg-gray-50 rounded-lg p-4">
                <button @click="previousMonth" class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h3 class="text-xl font-bold text-gray-900">{{ monthYear }}</h3>
                <button @click="nextMonth" class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2">
                <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" :key="day"
                    class="text-center text-sm font-medium text-gray-500 py-2">
                    {{ day }}
                </div>
                <button v-for="date in daysInMonth" :key="date.toISOString()" @click="selectDate(date)" :disabled="isPast(date) || loading"
                    :class="[
                        'aspect-square rounded-lg p-2 text-sm font-medium',
                        isPast(date)
                            ? 'text-gray-300 cursor-not-allowed'
                            : 'text-gray-900 hover:bg-indigo-100 cursor-pointer',
                        selectedDate === formatDate(date) ? 'bg-indigo-600 text-white hover:bg-indigo-700' : ''
                    ]">
                    {{ date.getDate() }}
                </button>
            </div>
        </div>
    </div>
</template>
