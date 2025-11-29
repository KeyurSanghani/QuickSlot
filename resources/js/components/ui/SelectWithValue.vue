<script setup lang="ts">
import { computed, ref, watch, nextTick, onMounted, onUnmounted } from 'vue'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, SelectIcon } from '@/components/ui/select'
import { Input } from '@/components/ui/input'
import { Search, X, Loader2 } from 'lucide-vue-next'
import { cn } from '@/lib/utils'

interface Option {
    value: string | number
    label: string
    [key: string]: any // Allow additional properties
}

interface Props {
    modelValue: string | number | null | undefined
    options: Option[]
    placeholder?: string
    disabled?: boolean
    class?: string
    loading?: boolean
    searchable?: boolean
    searchPlaceholder?: string
    noOptionsText?: string
    maxHeight?: string
    /** Enable virtual scrolling for large datasets (1000+ items) */
    virtual?: boolean
    /** Height of each option item in virtual mode (default: 35px) */
    itemHeight?: number
    /** Number of items to render outside visible area for smoother scrolling */
    overscan?: number
    /** Allow clearing the selected value */
    nullable?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Select an option',
    disabled: false,
    class: '',
    loading: false,
    searchable: true,
    searchPlaceholder: 'Search options...',
    noOptionsText: 'No options found',
    maxHeight: '300px',
    virtual: false,
    itemHeight: 35,
    overscan: 5,
    nullable: false
})

const emit = defineEmits<{
    'update:modelValue': [value: any]
}>()

const searchTerm = ref('')
const searchInput = ref<any>(null)
const isOpen = ref(false)
const scrollElement = ref<HTMLElement>()

// Custom Virtual scrolling setup
const parentRef = ref<HTMLElement>()
const scrollTop = ref(0)

// Virtual scrolling calculations
const containerHeight = computed(() => {
    return parseInt(props.maxHeight.replace('px', ''))
})

const visibleCount = computed(() => {
    return Math.ceil(containerHeight.value / props.itemHeight)
})

const startIndex = computed(() => {
    if (!props.virtual) return 0
    return Math.max(0, Math.floor(scrollTop.value / props.itemHeight) - props.overscan)
})

const endIndex = computed(() => {
    if (!props.virtual) return filteredOptions.value.length - 1
    return Math.min(
        startIndex.value + visibleCount.value + (props.overscan * 2),
        filteredOptions.value.length - 1
    )
})

const visibleOptions = computed(() => {
    if (!props.virtual) return filteredOptions.value
    return filteredOptions.value.slice(startIndex.value, endIndex.value + 1)
})

const totalHeight = computed(() => {
    return filteredOptions.value.length * props.itemHeight
})

const offsetY = computed(() => {
    return startIndex.value * props.itemHeight
})

// Scroll handler for virtual scrolling
const handleScroll = (event: Event) => {
    if (!props.virtual) return
    const target = event.target as HTMLElement
    scrollTop.value = target.scrollTop
}

// Lifecycle
onMounted(() => {
    if (parentRef.value) {
        parentRef.value.addEventListener('scroll', handleScroll, { passive: true })
    }
})

onUnmounted(() => {
    if (parentRef.value) {
        parentRef.value.removeEventListener('scroll', handleScroll)
    }
})

const selectedOption = computed(() => {
    return props.options.find(option => option.value === props.modelValue)
})

const filteredOptions = computed(() => {
    if (!props.searchable || !searchTerm.value.trim()) {
        return props.options
    }
    
    const search = searchTerm.value.toLowerCase().trim()
    return props.options.filter(option => 
        option.label.toLowerCase().includes(search)
    )
})

const handleValueChange = (value: any) => {
    emit('update:modelValue', value)
    searchTerm.value = ''
    isOpen.value = false
}

const clearValue = (event: Event) => {
    event.stopPropagation()
    event.preventDefault()
    emit('update:modelValue', null)
}

const handleOpenChange = (open: boolean) => {
    isOpen.value = open
    if (open && props.searchable) {
        nextTick(() => {
            const inputElement = searchInput.value?.$el || searchInput.value
            if (inputElement && typeof inputElement.focus === 'function') {
                inputElement.focus()
            }
        })
    } else {
        searchTerm.value = ''
    }
}

const clearSearch = () => {
    searchTerm.value = ''
    nextTick(() => {
        const inputElement = searchInput.value?.$el || searchInput.value
        if (inputElement && typeof inputElement.focus === 'function') {
            inputElement.focus()
        }
    })
}

// Watch for search term changes and scroll to top when searching
watch(searchTerm, () => {
    // Reset scroll position when searching
    scrollTop.value = 0
    if (parentRef.value) {
        parentRef.value.scrollTop = 0
    }
    
    nextTick(() => {
        const content = document.querySelector('[data-slot="select-content"]')
        if (content) {
            content.scrollTop = 0
        }
    })
})
</script>

<template>
    <Select 
        :model-value="modelValue" 
        @update:model-value="handleValueChange" 
        :disabled="disabled || loading"
        @update:open="handleOpenChange"
    >
        <SelectTrigger :class="cn('relative', props.class)">
            <slot name="trigger" :selected="selectedOption" :loading="loading">
                <SelectValue :placeholder="loading ? 'Loading...' : placeholder">
                    {{ selectedOption?.label || (loading ? 'Loading...' : placeholder) }}
                </SelectValue>
            </slot>
            <!-- Clear Button -->
            <button
                v-if="nullable && modelValue !== null && modelValue !== undefined && !loading && !disabled"
                type="button"
                @click.stop.prevent="clearValue"
                @mousedown.stop.prevent
                class="absolute right-8 top-1/2 -translate-y-1/2 h-4 w-4 rounded-sm opacity-50 hover:opacity-100 transition-opacity z-10"
            >
                <X class="h-3.5 w-3.5" />
            </button>
            <SelectIcon v-if="!loading" />
            <slot name="loading-icon" v-if="loading">
                <Loader2 class="h-4 w-4 animate-spin text-muted-foreground" />
            </slot>
        </SelectTrigger>
        <SelectContent 
            :class="cn('p-0', `max-h-[${maxHeight}] overflow-y-auto`)"
            :style="{ maxHeight: maxHeight }"
        >
            <!-- Search Input (only show if searchable) -->
            <div v-if="searchable" class="sticky top-0 z-10 bg-popover border-b border-border p-2">
                <div class="relative">
                    <Search class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        ref="searchInput"
                        v-model="searchTerm"
                        :placeholder="searchPlaceholder"
                        class="pl-8 pr-8 h-8 text-sm border-border/50 focus:border-primary/50"
                    />
                    <button
                        v-if="searchTerm"
                        type="button"
                        @click="clearSearch"
                        class="absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors"
                    >
                        <X class="h-3 w-3" />
                    </button>
                </div>
            </div>

            <!-- Options List with Virtual or Regular Scrolling -->
            <div 
                v-if="!virtual"
                class="max-h-full overflow-y-auto"
            >
                <template v-if="filteredOptions.length > 0">
                    <SelectItem 
                        v-for="option in filteredOptions" 
                        :key="option.value" 
                        :value="option.value"
                        class="cursor-pointer hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                    >
                        <slot name="option" :option="option">
                            {{ option.label }}
                        </slot>
                    </SelectItem>
                </template>
                <div v-else class="p-4 text-center text-sm text-muted-foreground">
                    {{ searchTerm ? noOptionsText : 'No options available' }}
                </div>
            </div>

            <!-- Virtual Scrolling List -->
            <div 
                v-else
                ref="parentRef"
                class="overflow-auto scrollbar-hide"
                :style="{ 
                    height: maxHeight,
                    maxHeight: maxHeight
                }"
                @scroll="handleScroll"
            >
                <div
                    v-if="filteredOptions.length > 0"
                    class="relative w-full"
                    :style="{
                        height: `${totalHeight}px`
                    }"
                >
                    <div
                        class="absolute top-0 left-0 w-full"
                        :style="{
                            transform: `translateY(${offsetY}px)`
                        }"
                    >
                        <SelectItem
                            v-for="(option, index) in visibleOptions"
                            :key="`${startIndex + index}-${option.value}`"
                            :value="option.value"
                            class="cursor-pointer hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground flex items-center"
                            :style="{ 
                                height: `${itemHeight}px`,
                                minHeight: `${itemHeight}px`
                            }"
                        >
                            <slot name="option" :option="option">
                                {{ option.label }}
                            </slot>
                        </SelectItem>
                    </div>
                </div>
                <div v-else class="p-4 text-center text-sm text-muted-foreground">
                    {{ searchTerm ? noOptionsText : 'No options available' }}
                </div>
            </div>
        </SelectContent>
    </Select>
</template>

<style scoped>
.scrollbar-hide {
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}

.scrollbar-hide::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}
</style>

