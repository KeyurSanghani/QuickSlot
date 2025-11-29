<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { Check, ChevronsUpDown, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Option {
    value: string | number;
    label: string;
    [key: string]: any;
}

interface Props {
    modelValue: (string | number)[];
    options: Option[];
    placeholder?: string;
    disabled?: boolean;
    class?: string;
    searchPlaceholder?: string;
    noOptionsText?: string;
    maxHeight?: string;
    maxDisplayItems?: number;
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Select options',
    disabled: false,
    class: '',
    searchPlaceholder: 'Search...',
    noOptionsText: 'No options found',
    maxHeight: '300px',
    maxDisplayItems: 2,
});

const emit = defineEmits<{
    'update:modelValue': [value: (string | number)[]];
}>();

const open = ref(false);

const selectedOptions = computed(() => {
    return props.options.filter((option) => props.modelValue.includes(option.value));
});

const displayText = computed(() => {
    if (selectedOptions.value.length === 0) {
        return props.placeholder;
    }
    
    if (selectedOptions.value.length <= props.maxDisplayItems) {
        return selectedOptions.value.map((opt) => opt.label).join(', ');
    }
    
    return `${selectedOptions.value.length} selected`;
});

const isSelected = (value: string | number) => {
    return props.modelValue.includes(value);
};

const handleToggle = (value: string | number) => {
    const newValue = [...props.modelValue];
    const index = newValue.indexOf(value);
    
    if (index > -1) {
        newValue.splice(index, 1);
    } else {
        newValue.push(value);
    }
    
    emit('update:modelValue', newValue);
};

const removeItem = (value: string | number, event: Event) => {
    event.stopPropagation();
    const newValue = props.modelValue.filter((v) => v !== value);
    emit('update:modelValue', newValue);
};

const clearAll = (event: Event) => {
    event.stopPropagation();
    emit('update:modelValue', []);
};
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                role="combobox"
                :aria-expanded="open"
                :class="cn('w-full justify-between', props.class)"
                :disabled="disabled"
            >
                <span class="truncate text-left">{{ displayText }}</span>
                <div class="flex items-center gap-1">
                    <X
                        v-if="modelValue.length > 0 && !disabled"
                        class="ml-2 h-4 w-4 shrink-0 opacity-50 hover:opacity-100"
                        @click.stop="clearAll"
                    />
                    <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                </div>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-full p-0" align="start">
            <Command>
                <CommandInput :placeholder="searchPlaceholder" />
                <CommandEmpty>{{ noOptionsText }}</CommandEmpty>
                <CommandList :style="{ maxHeight: maxHeight }">
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option.value"
                            :value="option.label"
                            @select="handleToggle(option.value)"
                            class="cursor-pointer"
                        >
                            <Checkbox
                                :checked="isSelected(option.value)"
                                class="mr-2"
                                @update:checked="() => handleToggle(option.value)"
                            />
                            <span>{{ option.label }}</span>
                            <Check
                                :class="cn('ml-auto h-4 w-4', isSelected(option.value) ? 'opacity-100' : 'opacity-0')"
                            />
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>

    <!-- Selected badges (optional display below the select) -->
    <div v-if="selectedOptions.length > 0 && selectedOptions.length <= maxDisplayItems" class="mt-2 flex flex-wrap gap-1">
        <Badge
            v-for="option in selectedOptions"
            :key="option.value"
            variant="secondary"
            class="gap-1"
        >
            {{ option.label }}
            <button
                type="button"
                class="ml-1 rounded-full outline-none hover:bg-muted"
                @click="(e) => removeItem(option.value, e)"
            >
                <X class="h-3 w-3" />
            </button>
        </Badge>
    </div>
</template>
