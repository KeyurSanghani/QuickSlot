<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { AlertCircle, AlertTriangle, CheckCircle, Info, X } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';

const page = usePage();
const isVisible = ref(false);

// Get flash messages from Inertia page props
const flashMessage = computed(() => {
    const props = page.props as any;
    if (props.success) {
        return { type: 'success', message: props.success };
    }
    if (props.error) {
        return { type: 'destructive', message: props.error };
    }
    if (props.warning) {
        return { type: 'warning', message: props.warning };
    }
    if (props.info) {
        return { type: 'default', message: props.info };
    }

    return null;
});

const getIcon = (type: string) => {
    switch (type) {
        case 'success':
            return CheckCircle;
        case 'destructive':
            return AlertCircle;
        case 'warning':
            return AlertTriangle;
        default:
            return Info;
    }
};

const getVariantClasses = (type: string) => {
    switch (type) {
        case 'success':
            return 'bg-green-500 border-green-600 text-white';
        case 'destructive':
            return 'bg-red-500 border-red-600 text-white';
        case 'warning':
            return 'bg-yellow-500 border-yellow-600 text-white';
        default:
            return 'bg-blue-500 border-blue-600 text-white';
    }
};

const getIconClasses = (type: string) => {
    switch (type) {
        case 'success':
            return 'text-white';
        case 'destructive':
            return 'text-white';
        case 'warning':
            return 'text-white';
        default:
            return 'text-white';
    }
};

const dismiss = () => {
    isVisible.value = false;
};

// Auto-dismiss after 5 seconds
let timeoutId: ReturnType<typeof setTimeout>;

const startAutoDismiss = () => {
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
    timeoutId = setTimeout(() => {
        dismiss();
    }, 5000);
};

// Watch for new flash messages
watch(
    flashMessage,
    (newMessage) => {
        if (newMessage) {
            isVisible.value = true;
            startAutoDismiss();
        } else {
            isVisible.value = false;
        }
    },
    { immediate: true },
);

onMounted(() => {
    if (flashMessage.value) {
        isVisible.value = true;
        startAutoDismiss();
    }
});
</script>

<template>
    <!-- Toast Container - Fixed positioning -->
    <div class="fixed top-4 right-4 z-50 w-96 max-w-sm">
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 transform translate-x-full"
            enter-to-class="opacity-100 transform translate-x-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 transform translate-x-0"
            leave-to-class="opacity-0 transform translate-x-full"
        >
            <div
                v-if="isVisible && flashMessage"
                :class="['relative rounded-lg border p-4 shadow-lg backdrop-blur-sm', getVariantClasses(flashMessage.type)]"
                role="alert"
            >
                <div class="flex items-start gap-3">
                    <component :is="getIcon(flashMessage.type)" :class="['mt-0.5 h-5 w-5 flex-shrink-0', getIconClasses(flashMessage.type)]" />
                    <div class="min-w-0 flex-1">
                        <p class="text-sm leading-5 font-medium text-white">
                            {{ flashMessage.message }}
                        </p>
                    </div>
                    <button
                        @click="dismiss"
                        class="ml-2 flex-shrink-0 rounded-md p-1.5 transition-colors hover:bg-white/20 text-white"
                        aria-label="Close notification"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>
