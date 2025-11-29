<script setup lang="ts">
import type { RadioGroupItemProps } from 'reka-ui'
import { cn } from '@/lib/utils'
import { Circle } from 'lucide-vue-next'
import { RadioGroupIndicator, RadioGroupItem } from 'reka-ui'
import { computed, type HTMLAttributes } from 'vue'

const props = defineProps<RadioGroupItemProps & { class?: HTMLAttributes['class'] }>()

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})
</script>

<template>
  <RadioGroupItem
    data-slot="radio-group-item"
    v-bind="delegatedProps"
    :class="
      cn('border-input data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground data-[state=checked]:border-primary focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-full border shadow-xs transition-shadow outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50',
         props.class)"
  >
    <RadioGroupIndicator
      data-slot="radio-group-indicator"
      class="flex items-center justify-center"
    >
      <Circle class="size-2 fill-current text-current" />
    </RadioGroupIndicator>
  </RadioGroupItem>
</template>
