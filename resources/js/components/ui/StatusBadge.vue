<script setup lang="ts">
import { Badge } from '@/components/ui/badge'
import ConfirmationDialog from '@/components/ui/ConfirmationDialog.vue'

interface Props {
    /**
     * Whether the entity is active (1/true) or inactive (0/false)
     */
    isActive: number | boolean
    /**
     * Entity name for confirmation dialog
     */
    entityName: string
    /**
     * Entity type (e.g., 'User', 'Company')
     */
    entityType?: string
    /**
     * Whether the action is loading
     */
    isLoading?: boolean
    /**
     * Custom confirmation title
     */
    confirmationTitle?: string
    /**
     * Custom confirmation description
     */
    confirmationDescription?: string
    /**
     * Additional CSS classes
     */
    className?: string
}

const props = withDefaults(defineProps<Props>(), {
    entityType: 'Entity',
    isLoading: false,
    className: ''
})

// Emits
const emit = defineEmits<{
    'status-toggle': []
}>()

const getStatusBadgeVariant = (isActive: number | boolean) => {
    return isActive ? 'default' : 'outline'
}

const getDefaultConfirmationTitle = () => {
    return props.confirmationTitle || `${props.isActive ? 'Deactivate' : 'Activate'} ${props.entityType}`
}

const getDefaultConfirmationDescription = () => {
    if (props.confirmationDescription) {
        return props.confirmationDescription
    }
    
    const action = props.isActive ? 'deactivate' : 'activate'
    const consequence = props.isActive 
        ? (props.entityType.toLowerCase() === 'user' ? 'revoke their access to the system' : 'suspend their services')
        : (props.entityType.toLowerCase() === 'user' ? 'grant them access to the system' : 'restore their services')
    
    return `Are you sure you want to ${action} ${props.entityName}? This will ${consequence}.`
}

const handleStatusToggle = () => {
    emit('status-toggle')
}
</script>

<template>
    <ConfirmationDialog
        :title="getDefaultConfirmationTitle()"
        :description="getDefaultConfirmationDescription()"
        :confirm-text="`${isActive ? 'Deactivate' : 'Activate'}`"
        variant="warning"
        :is-loading="isLoading"
        @confirm="handleStatusToggle"
    >
        <template #trigger>
            <Badge 
                :variant="getStatusBadgeVariant(isActive)"
                :class="[
                    isActive ? 'bg-green-500/10 text-green-600 border-green-500/20 dark:bg-green-500/10 dark:text-green-400' : '',
                    'cursor-pointer hover:opacity-80 transition-opacity shadow-sm',
                    className
                ]"
                role="button"
            >
                <div 
                    class="w-1.5 h-1.5 rounded-full mr-1.5"
                    :class="isActive ? 'bg-green-500' : 'bg-gray-400'"
                ></div>
                {{ isActive ? 'Active' : 'Inactive' }}
            </Badge>
        </template>
    </ConfirmationDialog>
</template>
