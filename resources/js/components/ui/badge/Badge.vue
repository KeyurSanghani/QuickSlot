<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { computed } from 'vue'
import { badgeVariants, type BadgeVariants } from '.'
import { cn } from '@/lib/utils'

interface BadgeProps {
  variant?: BadgeVariants['variant']
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<BadgeProps>(), {
  variant: 'default',
})

const badgeClasses = computed(() => {
  return cn(badgeVariants({ variant: props.variant }), props.class)
})
</script>

<template>
  <div :class="badgeClasses">
    <slot />
  </div>
</template>
