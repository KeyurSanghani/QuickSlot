<script setup lang="ts">
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import { router } from '@inertiajs/vue3';
import { BadgeCheck, LogOut, Settings, Sparkles } from 'lucide-vue-next';

interface Props {
    user: {
        name: string;
        email: string;
        avatar?: string;
    };
}

const props = defineProps<Props>();

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-semibold">{{ props.user.name }}</span>
                <span class="truncate text-xs text-muted-foreground">{{ props.user.email }}</span>
            </div>
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem as-child class="cursor-pointer">
            <a :href="route('profile.edit')">
                <BadgeCheck class="mr-2 size-4" />
                Profile
            </a>
        </DropdownMenuItem>
        <DropdownMenuItem as-child class="cursor-pointer">
            <a :href="route('appearance')">
                <Sparkles class="mr-2 size-4" />
                Appearance
            </a>
        </DropdownMenuItem>
        <DropdownMenuItem as-child class="cursor-pointer">
            <a :href="route('password.edit')">
                <Settings class="mr-2 size-4" />
                Settings
            </a>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem class="cursor-pointer" @click="logout">
        <LogOut class="mr-2 size-4" />
        Log out
    </DropdownMenuItem>
</template>
