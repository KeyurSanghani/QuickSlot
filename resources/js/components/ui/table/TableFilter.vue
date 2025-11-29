<script setup lang="ts">
import { ref, computed } from 'vue'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Filter, X } from 'lucide-vue-next'
import { STATUS, TRASH_STATUS } from '@/constants/enums'

export interface FilterOption {
    label: string
    value: string | number | boolean
}

export interface FilterConfig {
    key: string
    label: string
    type: 'radio' | 'checkbox' | 'select'
    options: FilterOption[]
    defaultValue?: string | number | boolean
    placeholder?: string
}

interface Props {
    currentFilters?: Record<string, any>
    showStatusFilter?: boolean
    showTrashedFilter?: boolean
    customFilters?: FilterConfig[]
}

interface Emits {
    apply: [filters: Record<string, any>]
    clear: []
}

const props = withDefaults(defineProps<Props>(), {
    currentFilters: () => ({}),
    showStatusFilter: false,
    showTrashedFilter: false,
    customFilters: () => ([]),
})

const emit = defineEmits<Emits>()

// Internal filter configuration based on props
const internalFilterConfig = computed<FilterConfig[]>(() => {
    const config: FilterConfig[] = []
    if (props.showStatusFilter) {
        config.push({
            key: 'status',
            label: 'Status',
            type: 'radio',
            defaultValue: undefined,
            options: [
                { label: 'Active', value: STATUS.ACTIVE },
                { label: 'Inactive', value: STATUS.INACTIVE }
            ]
        })
    }
    if (props.showTrashedFilter) {
        config.push({
            key: 'trashed',
            label: 'Trashed',
            type: 'radio',
            defaultValue: undefined,
            options: [
                { label: 'Only Trash', value: TRASH_STATUS.ONLY_TRASHED },
                { label: 'With Trash', value: TRASH_STATUS.WITH_TRASHED }
            ]
        })
    }
    // Add custom filters
    if (props.customFilters && props.customFilters.length > 0) {
        config.push(...props.customFilters)
    }
    return config
})

// State
const isOpen = ref(false)
const localFilters = ref<Record<string, any>>({})

// Initialize local filters
const initializeFilters = () => {
    const initialized: Record<string, any> = {}
    internalFilterConfig.value.forEach(filter => {
        initialized[filter.key] = props.currentFilters[filter.key] ?? filter.defaultValue
    })
    localFilters.value = initialized
}

// Initialize on mount
initializeFilters()

// Computed
const activeFilterCount = computed(() => {
    return Object.values(localFilters.value).filter(value => 
        value !== undefined && value !== null && value !== ''
    ).length
})

// Methods
const applyFilters = () => {
    const cleanedFilters: Record<string, any> = {}
    
    Object.entries(localFilters.value).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            cleanedFilters[key] = value
        }
    })
    
    emit('apply', cleanedFilters)
    isOpen.value = false
}

const clearFilters = () => {
    internalFilterConfig.value.forEach(filter => {
        localFilters.value[filter.key] = undefined
    })
    emit('clear')
    isOpen.value = false
}

const clearIndividualFilter = (filterKey: string) => {
    localFilters.value[filterKey] = undefined
}

const handleOpenChange = (open: boolean) => {
    isOpen.value = open
    if (open) {
        initializeFilters()
    }
}
</script>

<template>
    <DropdownMenu :open="isOpen" @update:open="handleOpenChange">
        <DropdownMenuTrigger as-child>
            <Button variant="outline" size="sm" class="shadow-sm relative">
                <Filter class="h-4 w-4" />
                Filters
                <span 
                    v-if="activeFilterCount > 0" 
                    class="absolute -top-2 -right-2 h-5 w-5 bg-primary text-primary-foreground text-xs rounded-full flex items-center justify-center"
                >
                    {{ activeFilterCount }}
                </span>
            </Button>
        </DropdownMenuTrigger>
        
        <DropdownMenuContent 
            class="w-80 p-4" 
            align="end"
            :side-offset="5"
        >
            <div class="space-y-4">
                <!-- Header -->
                <div class="flex items-center gap-2 pb-2 border-b">
                    <Filter class="h-4 w-4" />
                    <span class="font-semibold text-sm">Filter Options</span>
                </div>

                <!-- Filter Sections -->
                <div 
                    v-for="filter in internalFilterConfig" 
                    :key="filter.key"
                    class="space-y-3"
                >
                    <div class="flex items-center justify-between">
                        <Label class="text-sm font-semibold">{{ filter.label }}</Label>
                        <Button 
                            v-if="localFilters[filter.key] !== undefined"
                            variant="ghost" 
                            size="sm" 
                            @click="clearIndividualFilter(filter.key)"
                            class="h-auto p-1 text-xs text-muted-foreground hover:text-foreground"
                        >
                            Clear
                        </Button>
                    </div>
                    
                    <!-- Radio/Checkbox Filters -->
                    <div v-if="filter.type === 'radio' || filter.type === 'checkbox'" class="flex items-center gap-4">
                        <div 
                            v-for="option in filter.options" 
                            :key="String(option.value)"
                            class="flex items-center space-x-2"
                        >
                            <input 
                                :id="`${filter.key}-${option.value}`"
                                v-model="localFilters[filter.key]" 
                                :type="filter.type"
                                :value="option.value" 
                                :name="filter.key"
                                class="w-4 h-4 text-primary bg-background border-gray-300 focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <Label 
                                :for="`${filter.key}-${option.value}`" 
                                class="text-sm cursor-pointer"
                            >
                                {{ option.label }}
                            </Label>
                        </div>
                    </div>

                    <!-- Select Dropdown Filters -->
                    <div v-else-if="filter.type === 'select'">
                        <Select v-model="localFilters[filter.key]">
                            <SelectTrigger class="w-full">
                                <SelectValue :placeholder="filter.placeholder || 'Select an option'" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem 
                                    v-for="option in filter.options" 
                                    :key="String(option.value)" 
                                    :value="String(option.value)"
                                >
                                    {{ option.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between pt-4 border-t">
                    <Button 
                        variant="outline" 
                        size="sm"
                        @click="clearFilters"
                        class="flex items-center gap-2"
                    >
                        <X class="h-3 w-3" />
                        Clear Filter
                    </Button>
                    <Button 
                        size="sm"
                        @click="applyFilters"
                    >
                        Apply
                    </Button>
                </div>
            </div>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
