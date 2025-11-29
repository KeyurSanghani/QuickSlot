<script setup lang="ts">
import { Button } from '@/components/ui/button';
</script>

<template>
    <!-- Theme Demonstration Component - Can be used as reference -->
    <div class="space-y-6 bg-background p-6">
        <!-- Button Variants -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-foreground">Button Variants</h3>
            <div class="flex flex-wrap gap-3">
                <Button variant="default">Primary Blue</Button>
                <Button variant="secondary">Secondary Green</Button>
                <Button variant="success">Success Green</Button>
                <Button variant="outline">Outlined</Button>
                <Button variant="ghost">Ghost</Button>
                <Button variant="destructive">Destructive</Button>
                <Button variant="warning">Warning</Button>
                <Button variant="info">Info</Button>
                <Button variant="link">Link Style</Button>
            </div>
        </div>

        <!-- Status Indicators -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-foreground">Status Indicators</h3>
            <div class="flex flex-wrap gap-3">
                <div class="rounded-full border border-primary-light bg-primary-light px-3 py-2 font-medium text-primary">Active Status</div>
                <div class="rounded-full border border-secondary-light bg-secondary-light px-3 py-2 font-medium text-secondary">Success Status</div>
                <div class="rounded-full border border-warning/20 bg-warning/10 px-3 py-2 font-medium text-warning">Warning Status</div>
                <div class="rounded-full border border-destructive/20 bg-destructive/10 px-3 py-2 font-medium text-destructive">Error Status</div>
            </div>
        </div>

        <!-- Cards & Interactive Elements -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-foreground">Interactive Cards</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="cursor-pointer rounded-lg border border-border bg-card p-4 transition-colors hover:border-primary-hover">
                    <h4 class="mb-2 font-semibold text-card-foreground">Primary Themed Card</h4>
                    <p class="text-muted-foreground">Hover to see primary color border</p>
                </div>
                <div class="cursor-pointer rounded-lg border border-border bg-card p-4 transition-colors hover:border-secondary-hover">
                    <h4 class="mb-2 font-semibold text-card-foreground">Secondary Themed Card</h4>
                    <p class="text-muted-foreground">Hover to see secondary color border</p>
                </div>
            </div>
        </div>

        <!-- Color Palette Reference -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-foreground">Color Palette</h3>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div class="space-y-2">
                    <div class="h-16 w-full rounded-lg bg-primary"></div>
                    <p class="text-sm font-medium text-foreground">Primary</p>
                </div>
                <div class="space-y-2">
                    <div class="h-16 w-full rounded-lg bg-secondary"></div>
                    <p class="text-sm font-medium text-foreground">Secondary</p>
                </div>
                <div class="space-y-2">
                    <div class="h-16 w-full rounded-lg bg-warning"></div>
                    <p class="text-sm font-medium text-foreground">Warning</p>
                </div>
                <div class="space-y-2">
                    <div class="h-16 w-full rounded-lg bg-info"></div>
                    <p class="text-sm font-medium text-foreground">Info</p>
                </div>
            </div>
        </div>
    </div>
</template>
