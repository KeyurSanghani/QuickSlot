<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <span :class="className" v-bind="$attrs" class="text-xl font-bold text-white">QuickSlot</span>
</template>
