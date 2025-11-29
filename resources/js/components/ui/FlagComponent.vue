<template>
    <span
        class="bg-foreground/20 flex h-4 w-6 overflow-hidden rounded-sm"
        :class="cn('', $attrs.class ?? '')">
        <img
            v-if="country"
            :src="`https://flagcdn.com/w40/${country.toLowerCase()}.png`"
            :alt="`${country} flag`"
            class="h-full w-full object-cover" />
    </span>
</template>

<script setup lang="ts">
import { cn } from '@/lib/utils'

interface Props {
    country?: string
}

defineProps<Props>()
</script>
