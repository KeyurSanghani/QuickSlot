<script setup lang="ts">
import type { Booking, PaginationMeta } from '@/types/booking'
import { ref } from 'vue'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, TablePagination } from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Textarea } from '@/components/ui/textarea'
import { Label } from '@/components/ui/label'
import ConfirmationDialog from '@/components/ui/ConfirmationDialog.vue'
import { Check, X, Trash2 } from 'lucide-vue-next'

defineProps<{
    bookings: Booking[]
    loading: boolean
    pagination: PaginationMeta
}>()

const emit = defineEmits<{
    confirm: [id: string]
    cancel: [id: string, reason?: string]
    complete: [id: string]
    delete: [id: string]
    pageChange: [page: number]
    changePerPage: [perPage: number]
}>()

const showCancelModal = ref(false)
const selectedBookingId = ref<string>('')
const cancellationReason = ref('')

const openCancelModal = (id: string) => {
    selectedBookingId.value = id
    showCancelModal.value = true
}

const submitCancel = () => {
    emit('cancel', selectedBookingId.value, cancellationReason.value)
    showCancelModal.value = false
    cancellationReason.value = ''
}

const getStatusVariant = (status: string): 'default' | 'secondary' | 'destructive' | 'outline' => {
    const variants: Record<string, 'default' | 'secondary' | 'destructive' | 'outline'> = {
        pending: 'outline',
        confirmed: 'default',
        cancelled: 'destructive',
        completed: 'secondary',
    }
    return variants[status] || 'outline'
}
</script>

<template>
    <div class="rounded-lg border border-border bg-card">
        <div v-if="loading" class="p-6">
            <div class="animate-pulse space-y-4">
                <div v-for="i in 5" :key="i" class="h-16 bg-muted rounded"></div>
            </div>
        </div>

        <div v-else-if="bookings.length === 0" class="p-12 text-center">
            <p class="text-muted-foreground">No bookings found</p>
        </div>

        <template v-else>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Client</TableHead>
                        <TableHead>Service</TableHead>
                        <TableHead>Date & Time</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="booking in bookings" :key="booking.id">
                        <TableCell>
                            <div class="font-medium">{{ booking.client_name }}</div>
                            <div class="text-sm text-muted-foreground">{{ booking.client_email }}</div>
                            <div v-if="booking.client_phone" class="text-sm text-muted-foreground">
                                {{ booking.client_phone }}
                            </div>
                        </TableCell>
                        <TableCell>
                            <div v-if="booking.service" class="font-medium">{{ booking.service.name }}</div>
                            <div v-else class="font-medium text-muted-foreground">No Service</div>
                            <div v-if="booking.service?.duration" class="text-sm text-muted-foreground">
                                {{ booking.service.duration }} min
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="font-medium">{{ booking.booking_date }}</div>
                            <div class="text-sm text-muted-foreground">
                                {{ booking.start_time }} - {{ booking.end_time }}
                            </div>
                        </TableCell>
                        <TableCell>
                            <Badge :variant="getStatusVariant(booking.status)">
                                {{ booking.status_label }}
                            </Badge>
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="flex justify-end gap-2">
                                <Button
                                    v-if="booking.status === 'pending'"
                                    @click="emit('confirm', booking.id)"
                                    size="sm"
                                    variant="outline"
                                >
                                    <Check class="h-4 w-4 mr-1" />
                                    Confirm
                                </Button>
                                <Button
                                    v-if="booking.status === 'confirmed'"
                                    @click="emit('complete', booking.id)"
                                    size="sm"
                                    variant="outline"
                                >
                                    <Check class="h-4 w-4 mr-1" />
                                    Complete
                                </Button>
                                <Button
                                    v-if="['pending', 'confirmed'].includes(booking.status)"
                                    @click="openCancelModal(booking.id)"
                                    size="sm"
                                    variant="outline"
                                >
                                    <X class="h-4 w-4 mr-1" />
                                    Cancel
                                </Button>
                                <ConfirmationDialog
                                    title="Delete Booking"
                                    description="Are you sure you want to delete this booking? This action cannot be undone."
                                    confirm-text="Delete"
                                    cancel-text="Cancel"
                                    variant="destructive"
                                    @confirm="emit('delete', booking.id)"
                                >
                                    <template #trigger>
                                        <Button
                                            size="sm"
                                            variant="outline"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </template>
                                </ConfirmationDialog>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <TablePagination 
                :pagination="pagination"
                @change-page="emit('pageChange', $event)"
                @change-per-page="emit('changePerPage', $event)"
            />
        </template>
    </div>

    <!-- Cancel Modal -->
    <Dialog v-model:open="showCancelModal">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Cancel Booking</DialogTitle>
                <DialogDescription>
                    Are you sure you want to cancel this booking? You can optionally provide a reason below.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid gap-2">
                    <Label for="reason">Cancellation Reason (Optional)</Label>
                    <Textarea
                        v-model="cancellationReason"
                        id="reason"
                        placeholder="Enter cancellation reason..."
                        :rows="3"
                    />
                </div>
            </div>
            <DialogFooter>
                <Button
                    @click="showCancelModal = false"
                    variant="outline"
                >
                    Close
                </Button>
                <Button
                    @click="submitCancel"
                    variant="destructive"
                >
                    Cancel Booking
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
