<script setup lang="ts">
import type { Service } from '@/types/booking'

defineProps<{
    services: Service[]
    loading: boolean
}>()

const emit = defineEmits<{
    select: [service: Service]
}>()
</script>

<template>
    <div class="mx-auto max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Select a Service</h2>

        <div v-if="loading" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="i in 3" :key="i" class="animate-pulse">
                <div class="h-48 bg-gray-200 rounded-lg"></div>
            </div>
        </div>

        <div v-else-if="services.length === 0" class="text-center py-12">
            <p class="text-gray-500">No services available at the moment.</p>
        </div>

        <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <button v-for="service in services" :key="service.id" @click="emit('select', service)"
                class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white p-6 text-left shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600">
                    {{ service.name }}
                </h3>
                <p v-if="service.description" class="mt-2 text-sm text-gray-500 line-clamp-2">
                    {{ service.description }}
                </p>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">{{ service.duration }} mins</span>
                    <span class="text-lg font-bold text-indigo-600">${{ service.price }}</span>
                </div>
            </button>
        </div>
    </div>
</template>
