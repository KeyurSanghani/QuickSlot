<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

interface TableSkeletonProps {
    rows?: number;
    columns?: number;
}

const props = withDefaults(defineProps<TableSkeletonProps>(), {
    rows: 5,
    columns: 5,
});
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-border/50">
        <Table>
            <TableHeader>
                <TableRow class="bg-muted/30">
                    <TableHead>
                        <Skeleton class="h-4 w-[120px]" />
                    </TableHead>
                    <TableHead class="hidden md:table-cell">
                        <Skeleton class="h-4 w-[80px]" />
                    </TableHead>
                    <TableHead class="hidden md:table-cell">
                        <Skeleton class="h-4 w-[80px]" />
                    </TableHead>
                    <TableHead class="hidden lg:table-cell">
                        <Skeleton class="h-4 w-[100px]" />
                    </TableHead>
                    <TableHead>
                        <Skeleton class="h-4 w-[80px]" />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="row in props.rows" :key="row" class="hover:bg-muted/30">
                    <!-- User column with avatar and details -->
                    <TableCell class="py-4">
                        <div class="flex items-center gap-3">
                            <Skeleton class="h-10 w-10 rounded-full" />
                            <div class="space-y-2">
                                <Skeleton class="h-4 w-[140px]" />
                                <Skeleton class="h-3 w-[180px]" />
                            </div>
                        </div>
                    </TableCell>
                    <!-- Role column -->
                    <TableCell class="hidden py-4 md:table-cell">
                        <Skeleton class="h-6 w-[70px] rounded-full" />
                    </TableCell>
                    <!-- Status column -->
                    <TableCell class="hidden py-4 md:table-cell">
                        <Skeleton class="h-6 w-[60px] rounded-full" />
                    </TableCell>
                    <!-- Date column -->
                    <TableCell class="hidden py-4 lg:table-cell">
                        <Skeleton class="h-4 w-[90px]" />
                    </TableCell>
                    <!-- Actions column -->
                    <TableCell class="py-4">
                        <div class="flex items-center gap-1">
                            <Skeleton class="h-8 w-8 rounded-md" />
                            <Skeleton class="h-8 w-8 rounded-md" />
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
