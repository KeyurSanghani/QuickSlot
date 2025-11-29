import { computed } from 'vue'
import { Button } from '@/components/ui/button'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
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

const changePerPage = (value: string) => {
    const perPage = parseInt(value)
    if (perPage !== props.pagination.per_page) {
        emit('changePerPage', perPage)
    }
}

export {
    props,
    emit,
    totalPages,
    currentPage,
    hasNextPage,
    hasPrevPage,
    startItem,
    endItem,
    totalItems,
    visiblePages,
    goToPage,
    goToFirstPage,
    goToLastPage,
    goToPrevPage,
    goToNextPage,
    changePerPage
}
