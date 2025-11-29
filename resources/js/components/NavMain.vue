<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGrid, Calendar, Briefcase, Clock } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage()

// Check if user has permissions
const hasPermission = (permission: string): boolean => {
    const permissions = page.props.auth?.permissions || []
    return permissions.includes(permission)
}

// Show booking management section if user has any booking-related permissions
const showBookingManagement = computed(() => {
    return hasPermission('view-booking') || 
           hasPermission('view-service') || 
           hasPermission('view-working-hour')
})
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Quick access</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton as-child :is-active="route().current('dashboard.index')" :tooltip="'Dashboard'">
                    <Link :href="route('dashboard.index')">
                        <component :is="LayoutGrid" />
                        <span>Dashboard</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>

    <SidebarGroup v-if="showBookingManagement" class="px-2 py-0">
        <SidebarGroupLabel>Booking Management</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-if="hasPermission('view-booking')">
                <SidebarMenuButton 
                    as-child 
                    :is-active="route().current('admin.bookings.manage')" 
                    :tooltip="'Manage Bookings'">
                    <Link :href="route('admin.bookings.manage')">
                        <component :is="Calendar" />
                        <span>Bookings</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem v-if="hasPermission('view-service')">
                <SidebarMenuButton 
                    as-child 
                    :is-active="route().current('admin.services.index')" 
                    :tooltip="'Manage Services'">
                    <Link :href="route('admin.services.index')">
                        <component :is="Briefcase" />
                        <span>Services</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>

            <SidebarMenuItem v-if="hasPermission('view-working-hour')">
                <SidebarMenuButton 
                    as-child 
                    :is-active="route().current('admin.working-hours.index')" 
                    :tooltip="'Manage Working Hours'">
                    <Link :href="route('admin.working-hours.index')">
                        <component :is="Clock" />
                        <span>Working Hours</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
