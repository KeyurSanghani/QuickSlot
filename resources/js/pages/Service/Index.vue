<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { serviceService } from '@/services/serviceService'
import { useToast } from '@/composables/useToast'
import type { Service } from '@/types/booking'

defineProps<{
    title: string
}>()

const { success, error: showError } = useToast()
const loading = ref(false)
const services = ref<Service[]>([])

const loadServices = async () => {
    try {
        loading.value = true
        const response = await serviceService.getAll(100)
        services.value = response.data.list
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to load services')
    } finally {
        loading.value = false
    }
}

const handleToggleStatus = async (id: string) => {
    try {
        await serviceService.toggleStatus(id)
        success('Service status updated successfully')
        loadServices()
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to update service status')
    }
}

const handleDelete = async (id: string) => {
    if (!confirm('Are you sure you want to delete this service?')) return

    try {
        await serviceService.delete(id)
        success('Service deleted successfully')
        loadServices()
    } catch (err: any) {
        showError(err.response?.data?.message || 'Failed to delete service')
    }
}

onMounted(() => {
    loadServices()
})
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Manage Services</h1>
                <p class="mt-1 text-sm text-gray-500">Configure the services you offer</p>
            </div>

            <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="i in 6" :key="i" class="h-48 bg-gray-200 rounded-lg animate-pulse"></div>
            </div>

            <div v-else-if="services.length === 0" class="text-center py-12">
                <p class="text-gray-500">No services found. Create one to get started.</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="service in services"
                    :key="service.id"
                    class="bg-white rounded-lg shadow p-6 border border-gray-200"
                >
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ service.name }}</h3>
                        <span
                            :class="[
                                'px-2 py-1 text-xs font-medium rounded-full',
                                service.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-gray-100 text-gray-800'
                            ]"
                        >
                            {{ service.is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <p v-if="service.description" class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ service.description }}
                    </p>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">{{ service.duration }} minutes</span>
                        <span class="text-lg font-bold text-indigo-600">${{ service.price }}</span>
                    </div>

                    <div class="flex space-x-2">
                        <button
                            @click="handleToggleStatus(service.id)"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            {{ service.is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                        <button
                            @click="handleDelete(service.id)"
                            class="px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
