<script setup lang="ts">
import { computed } from 'vue'
import { Button } from '@/components/ui/button'
import { LayoutGrid, List } from 'lucide-vue-next'
import { cn } from '@/lib/utils'

export type ViewMode = 'grid' | 'table'

interface Props {
    modelValue: ViewMode
    gridLabel?: string
    tableLabel?: string
    showLabels?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    gridLabel: 'Grid',
    tableLabel: 'Table',
    showLabels: false
})

const emit = defineEmits<{
    'update:modelValue': [value: ViewMode]
}>()

const isGridView = computed(() => props.modelValue === 'grid')
const isTableView = computed(() => props.modelValue === 'table')

const handleViewChange = (view: ViewMode) => {
    if (props.modelValue !== view) {
        emit('update:modelValue', view)
    }
}
</script>

<template>
    <div class="inline-flex items-center rounded-lg border border-border bg-background p-1 shadow-sm">
        <!-- Grid View Button -->
        <Button
            variant="ghost"
            size="sm"
            :class="cn(
                'h-8 gap-2 transition-all',
                isGridView
                    ? 'bg-primary text-primary-foreground shadow-sm hover:bg-primary hover:text-primary-foreground'
                    : 'text-muted-foreground hover:text-foreground hover:bg-muted'
            )"
            @click="handleViewChange('grid')"
        >
            <LayoutGrid class="h-4 w-4" />
            <span v-if="showLabels" class="hidden sm:inline-block">{{ gridLabel }}</span>
        </Button>

        <!-- Table View Button -->
        <Button
            variant="ghost"
            size="sm"
            :class="cn(
                'h-8 gap-2 transition-all',
                isTableView
                    ? 'bg-primary text-primary-foreground shadow-sm hover:bg-primary hover:text-primary-foreground'
                    : 'text-muted-foreground hover:text-foreground hover:bg-muted'
            )"
            @click="handleViewChange('table')"
        >
            <List class="h-4 w-4" />
            <span v-if="showLabels" class="hidden sm:inline-block">{{ tableLabel }}</span>
        </Button>
    </div>
</template>
