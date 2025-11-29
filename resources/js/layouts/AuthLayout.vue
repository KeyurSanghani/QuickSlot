<script setup lang="ts">
import FlashMessage from '@/components/FlashMessage.vue';
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <FlashMessage />
        <slot />
    </AuthLayout>
</template>
