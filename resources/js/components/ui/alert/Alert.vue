<script setup lang="ts">
import { cn } from '@/lib/utils';
import { cva, type VariantProps } from 'class-variance-authority';

const alertVariants = cva(
  'relative w-full rounded-lg border px-4 py-3 text-sm [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground [&>svg~*]:pl-7',
  {
    variants: {
      variant: {
        default: 'bg-background text-foreground border-border',
        destructive: 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
        success: 'border-green-500/50 text-green-700 bg-green-50 dark:border-green-500 dark:text-green-400 dark:bg-green-950/50 [&>svg]:text-green-600 dark:[&>svg]:text-green-400',
        warning: 'border-yellow-500/50 text-yellow-700 bg-yellow-50 dark:border-yellow-500 dark:text-yellow-400 dark:bg-yellow-950/50 [&>svg]:text-yellow-600 dark:[&>svg]:text-yellow-400',
      },
    },
    defaultVariants: {
      variant: 'default',
    },
  }
);

interface Props {
  variant?: VariantProps<typeof alertVariants>['variant'];
  class?: string;
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
});
</script>

<template>
  <div :class="cn(alertVariants({ variant: props.variant }), props.class)">
    <slot />
  </div>
</template>
