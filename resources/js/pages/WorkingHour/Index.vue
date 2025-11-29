<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { workingHourService } from '@/services/workingHourService'
import { useToast } from '@/composables/useToast'
import type { WorkingHour } from '@/types/booking'

defineProps<{
    title: string
}>()

const { success, error: showError } = useToast()
const loading = ref(false)
const workingHours = ref<WorkingHour[]>([])

const daysOfWeek = [
    { value: 1, label: 'Monday' },
    { value: 2, label: 'Tuesday' },
    { value: 3, label: 'Wednesday' },
    { value: 4, label: 'Thursday' },
    { value: 5, label: 'Friday' },
    { value: 6, label: 'Saturday' },
    { value: 0, label: 'Sunday' }
]

const groupedWorkingHours = computed(() => {
    const grouped: Record<number, WorkingHour[]> = {}
    
    workingHours.value.forEach(wh => {
        if (!grouped[wh.day_of_week]) {
            grouped[wh.day_of_week] = []
        }
        grouped[wh.day_of_week].push(wh)
    })
    
    return grouped
})

const formatTime = (time: string): string => {
    return new Date(`2000-01-01T${time}`).toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    })
}

const loadWorkingHours = async () => {
    try {
        loading.value = true
        const response = await workingHourService.getAll(100)
        workingHours.value = response.data.list
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to load working hours')
    } finally {
        loading.value = false
    }
}

const handleToggleStatus = async (id: string) => {
    try {
        await workingHourService.toggleStatus(id)
        success('Working hour status updated successfully')
        loadWorkingHours()
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to update working hour status')
    }
}

const handleDelete = async (id: string) => {
    if (!confirm('Are you sure you want to delete this working hour?')) return

    try {
        await workingHourService.delete(id)
        success('Working hour deleted successfully')
        loadWorkingHours()
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to delete working hour')
    }
}

onMounted(() => {
    loadWorkingHours()
})
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Manage Working Hours</h1>
                <p class="mt-1 text-sm text-gray-500">Configure your availability schedule</p>
            </div>

            <div v-if="loading" class="space-y-4">
                <div v-for="i in 7" :key="i" class="h-24 bg-gray-200 rounded-lg animate-pulse"></div>
            </div>

            <div v-else-if="workingHours.length === 0" class="text-center py-12">
                <p class="text-gray-500">No working hours configured. Add some to get started.</p>
            </div>

            <div v-else class="space-y-6">
                <div
                    v-for="day in daysOfWeek"
                    :key="day.value"
                    class="bg-white rounded-lg shadow border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">{{ day.label }}</h3>
                    </div>

                    <div v-if="!groupedWorkingHours[day.value]" class="px-6 py-8 text-center">
                        <p class="text-sm text-gray-500">No working hours set for this day</p>
                    </div>

                    <div v-else class="divide-y divide-gray-200">
                        <div
                            v-for="wh in groupedWorkingHours[day.value]"
                            :key="wh.id"
                            class="px-6 py-4 flex items-center justify-between"
                        >
                            <div class="flex items-center space-x-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ formatTime(wh.start_time) }} - {{ formatTime(wh.end_time) }}
                                    </span>
                                </div>
                                <span
                                    :class="[
                                        'px-2 py-1 text-xs font-medium rounded-full',
                                        wh.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800'
                                    ]"
                                >
                                    {{ wh.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="flex space-x-2">
                                <button
                                    @click="handleToggleStatus(wh.id)"
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    {{ wh.is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button
                                    @click="handleDelete(wh.id)"
                                    class="px-3 py-1 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
