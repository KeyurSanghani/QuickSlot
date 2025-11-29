<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { SelectItem, type SelectItemProps } from 'reka-ui'
import { cn } from '@/lib/utils'

interface Props extends SelectItemProps {
  class?: HTMLAttributes['class']
}

const props = defineProps<Props>()
</script>

<template>
  <SelectItem
    data-slot="select-item"
    v-bind="props"
    :class="cn(
      'relative flex w-full cursor-default select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
      props.class
    )"
  >
    <span class="absolute right-2 flex h-3.5 w-3.5 items-center justify-center">
      <slot name="indicator" />
    </span>
    <slot />
  </SelectItem>
</template>
