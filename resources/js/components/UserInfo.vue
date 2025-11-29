<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { getInitials } from '@/composables/useInitials';

interface Props {
    user: {
        name: string;
        email: string;
        avatar?: string;
    };
}

const props = defineProps<Props>();
</script>

<template>
    <Avatar class="size-8 rounded-lg">
        <AvatarImage v-if="props.user.avatar" :src="props.user.avatar" :alt="props.user.name" />
        <AvatarFallback class="rounded-lg bg-primary-light font-semibold text-primary">
            {{ getInitials(props.user.name) }}
        </AvatarFallback>
    </Avatar>
    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-semibold">{{ props.user.name }}</span>
        <span class="truncate text-xs text-muted-foreground">{{ props.user.email }}</span>
    </div>
</template>
