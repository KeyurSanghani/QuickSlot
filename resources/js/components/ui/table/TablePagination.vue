<script setup lang="ts">
import { computed } from 'vue'
import { Button } from '@/components/ui/button'
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next'

export interface PaginationData {
    current_page: number
    next_page: number | null
    from: number | null
    last_page: number
    per_page: number
    to: number | null
    total: number
}

interface Props {
    pagination: PaginationData
    perPageOptions?: number[]
    showPerPageSelector?: boolean
    showPageInfo?: boolean
}

interface Emits {
    (e: 'changePage', page: number): void
    (e: 'changePerPage', perPage: number): void
}

const props = withDefaults(defineProps<Props>(), {
    perPageOptions: () => [10, 25, 50, 100],
    showPerPageSelector: true,
    showPageInfo: true
})

const emit = defineEmits<Emits>()

// Computed properties
const totalPages = computed(() => props.pagination.last_page)
const currentPage = computed(() => props.pagination.current_page)
const hasNextPage = computed(() => props.pagination.next_page !== null)
const hasPrevPage = computed(() => currentPage.value > 1)
const startItem = computed(() => props.pagination.from || 0)
const endItem = computed(() => props.pagination.to || 0)
const totalItems = computed(() => props.pagination.total)

// Generate page numbers to show
const visiblePages = computed(() => {
    const pages: number[] = []
    const total = totalPages.value
    const current = currentPage.value
    
    if (total <= 7) {
        // Show all pages if total is 7 or less
        for (let i = 1; i <= total; i++) {
            pages.push(i)
        }
    } else {
        // Show first page
        pages.push(1)
        
        if (current > 4) {
            pages.push(-1) // Ellipsis
        }
        
        // Show pages around current page
        const start = Math.max(2, current - 1)
        const end = Math.min(total - 1, current + 1)
        
        for (let i = start; i <= end; i++) {
            if (!pages.includes(i)) {
                pages.push(i)
            }
        }
        
        if (current < total - 3) {
            pages.push(-2) // Ellipsis
        }
        
        // Show last page
        if (!pages.includes(total)) {
            pages.push(total)
        }
    }
    
    return pages
})

// Methods
const goToPage = (page: number) => {
    if (page >= 1 && page <= totalPages.value && page !== currentPage.value) {
        emit('changePage', page)
    }
}

const goToFirstPage = () => goToPage(1)
const goToLastPage = () => goToPage(totalPages.value)
const goToPrevPage = () => goToPage(currentPage.value - 1)
const goToNextPage = () => goToPage(currentPage.value + 1)

const changePerPage = (event: Event) => {
    const target = event.target as HTMLSelectElement
    const perPage = parseInt(target.value)
    if (perPage !== props.pagination.per_page) {
        emit('changePerPage', perPage)
    }
}
</script>

<template>
    <div class="flex flex-col gap-3 border-t border-border/50 bg-muted/20 px-4 py-3 sm:px-6 sm:py-4">
        <!-- Mobile Layout: Stack everything vertically -->
        <div class="flex flex-col gap-3 sm:hidden">
            <!-- Page Info (Mobile) -->
            <div v-if="showPageInfo" class="text-center">
                <span class="text-sm text-muted-foreground">
                    {{ startItem }}-{{ endItem }} of {{ totalItems }}
                </span>
            </div>

            <!-- Controls Row 1: Per Page Selector (Mobile) -->
            <div v-if="showPerPageSelector" class="flex items-center justify-center gap-2">
                <span class="text-sm text-muted-foreground">Show:</span>
                <select 
                    :value="pagination.per_page"
                    @change="changePerPage"
                    class="h-8 w-16 rounded-md border border-border bg-background px-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >
                    <option v-for="option in perPageOptions" :key="option" :value="option">
                        {{ option }}
                    </option>
                </select>
            </div>

            <!-- Controls Row 2: Navigation (Mobile) -->
            <div class="flex items-center justify-center gap-2">
                <!-- Previous Page -->
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!hasPrevPage"
                    @click="goToPrevPage"
                    class="h-8 px-3 text-xs"
                >
                    <ChevronLeft class="h-4 w-4 mr-1" />
                    Prev
                </Button>

                <!-- Current Page Indicator -->
                <span class="text-sm text-muted-foreground px-2">
                    {{ currentPage }} / {{ totalPages }}
                </span>

                <!-- Next Page -->
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!hasNextPage"
                    @click="goToNextPage"
                    class="h-8 px-3 text-xs"
                >
                    Next
                    <ChevronRight class="h-4 w-4 ml-1" />
                </Button>
            </div>
        </div>

        <!-- Desktop Layout: Original horizontal layout -->
        <div class="hidden sm:flex sm:items-center sm:justify-between">
            <!-- Page Info (Desktop) -->
            <div v-if="showPageInfo" class="flex items-center gap-2">
                <span class="text-sm text-muted-foreground">
                    Showing 
                    <span class="font-medium text-foreground">{{ startItem }}</span>
                    to 
                    <span class="font-medium text-foreground">{{ endItem }}</span>
                    of 
                    <span class="font-medium text-foreground">{{ totalItems }}</span>
                    results
                </span>
            </div>

            <!-- Pagination Controls (Desktop) -->
            <div class="flex items-center gap-2">
                <!-- Per Page Selector (Desktop) -->
                <div v-if="showPerPageSelector" class="flex items-center gap-2">
                    <span class="text-sm text-muted-foreground whitespace-nowrap">Rows per page:</span>
                    <select 
                        :value="pagination.per_page"
                        @change="changePerPage"
                        class="h-8 w-16 rounded-md border border-border bg-background px-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                    >
                        <option v-for="option in perPageOptions" :key="option" :value="option">
                            {{ option }}
                        </option>
                    </select>
                </div>

                <!-- Page Navigation (Desktop) -->
                <div class="flex items-center gap-1">
                    <!-- First Page -->
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!hasPrevPage"
                        @click="goToFirstPage"
                        class="h-8 w-8 p-0"
                    >
                        <ChevronsLeft class="h-4 w-4" />
                    </Button>

                    <!-- Previous Page -->
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!hasPrevPage"
                        @click="goToPrevPage"
                        class="h-8 w-8 p-0"
                    >
                        <ChevronLeft class="h-4 w-4" />
                    </Button>

                    <!-- Page Numbers -->
                    <div class="flex items-center gap-1">
                        <template v-for="page in visiblePages" :key="page">
                            <!-- Ellipsis -->
                            <span v-if="page < 0" class="px-2 text-muted-foreground">
                                ...
                            </span>
                            <!-- Page Number -->
                            <Button
                                v-else
                                :variant="page === currentPage ? 'default' : 'outline'"
                                size="sm"
                                @click="goToPage(page)"
                                class="h-8 w-8 p-0"
                                :class="{ 'bg-primary text-primary-foreground': page === currentPage }"
                            >
                                {{ page }}
                            </Button>
                        </template>
                    </div>

                    <!-- Next Page -->
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!hasNextPage"
                        @click="goToNextPage"
                        class="h-8 w-8 p-0"
                    >
                        <ChevronRight class="h-4 w-4" />
                    </Button>

                    <!-- Last Page -->
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!hasNextPage"
                        @click="goToLastPage"
                        class="h-8 w-8 p-0"
                    >
                        <ChevronsRight class="h-4 w-4" />
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
