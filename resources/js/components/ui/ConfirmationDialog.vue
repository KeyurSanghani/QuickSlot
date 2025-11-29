<script setup lang="ts">
import { ref, watch } from 'vue'
import { AlertTriangle } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'

interface Props {
    title?: string
    description?: string
    confirmText?: string
    cancelText?: string
    variant?: 'default' | 'destructive' | 'warning'
    isLoading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Are you sure?',
    description: 'This action cannot be undone.',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    variant: 'default',
    isLoading: false
})

const emit = defineEmits<{
    confirm: []
    cancel: []
}>()

const isOpen = ref(false)
const wasLoading = ref(false)

// Watch for loading state changes to close dialog when action completes
watch(() => props.isLoading, (newLoading, oldLoading) => {
    // If we were loading and now we're not, the action completed
    if (wasLoading.value && !newLoading) {
        isOpen.value = false
        wasLoading.value = false
    }
    
    // Track if we started loading
    if (newLoading) {
        wasLoading.value = true
    }
})

const handleConfirm = () => {
    emit('confirm')
}

const handleCancel = () => {
    isOpen.value = false
    emit('cancel')
}

const getVariantClasses = () => {
    switch (props.variant) {
        case 'destructive':
            return 'text-destructive'
        case 'warning':
            return 'text-amber-600'
        default:
            return 'text-foreground'
    }
}

const getButtonVariant = () => {
    switch (props.variant) {
        case 'destructive':
            return 'destructive'
        case 'warning':
            return 'default'
        default:
            return 'default'
    }
}
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>
        <DialogContent class="sm:max-w-md">
            <DialogHeader class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full"
                         :class="{
                             'bg-destructive/10': variant === 'destructive',
                             'bg-amber-100 dark:bg-amber-900/20': variant === 'warning',
                             'bg-primary/10': variant === 'default'
                         }">
                        <AlertTriangle class="h-5 w-5"
                                     :class="{
                                         'text-destructive': variant === 'destructive',
                                         'text-amber-600': variant === 'warning',
                                         'text-primary': variant === 'default'
                                     }" />
                    </div>
                    <DialogTitle :class="getVariantClasses()">
                        {{ title }}
                    </DialogTitle>
                </div>
                <DialogDescription class="text-sm text-muted-foreground">
                    {{ description }}
                </DialogDescription>
            </DialogHeader>
            <DialogFooter class="gap-2 sm:gap-2">
                <Button
                    variant="outline"
                    @click="handleCancel"
                    :disabled="isLoading"
                >
                    {{ cancelText }}
                </Button>
                <Button
                    :variant="getButtonVariant()"
                    @click="handleConfirm"
                    :disabled="isLoading"
                >
                    {{ isLoading ? 'Processing...' : confirmText }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
