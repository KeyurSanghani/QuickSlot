<template>
    <PhoneInput
        v-model="phoneNumber"
        :no-use-browser-locale="noUseBrowserLocale"
        :fetch-country="fetchCountry"
        class="flex"
        :country-code="countryCode"
        :country-locale="countryLocale"
        :ignored-countries="ignoredCountries"
        :only-countries="onlyCountries"
        @update:model-value="handleUpdate">
        <template #selector="{ inputValue, updateInputValue, countries }">
            <Popover v-model:open="open">
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        class="flex gap-1 rounded-e-none rounded-s-lg px-3"
                        :class="disabled ? 'cursor-not-allowed opacity-50' : ''"
                        :disabled="disabled">
                        <FlagComponent :country="inputValue" />
                        <ChevronsUpDown class="-mr-2 h-4 w-4 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-[300px] p-0">
                    <Command>
                        <CommandInput placeholder="Search country..." />
                        <CommandEmpty>No country found.</CommandEmpty>
                        <CommandList>
                            <CommandGroup>
                                <CommandItem
                                    v-for="option in countries"
                                    :key="option.iso2"
                                    :value="option.name"
                                    class="gap-2"
                                    @select="
                                        () => {
                                            updateInputValue(option.iso2)
                                            open = false
                                            focused = true
                                        }
                                    ">
                                    <FlagComponent :country="option?.iso2" />
                                    <span class="flex-1 text-sm">{{
                                        option.name
                                    }}</span>
                                    <span class="text-foreground/50 text-sm">{{
                                        option.dialCode
                                    }}</span>
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </template>

        <template #input="{ inputValue, updateInputValue, placeholder }">
            <Input
                ref="phoneInput"
                class="rounded-e-lg rounded-s-none"
                type="text"
                :model-value="inputValue"
                :placeholder="placeholder"
                :disabled="disabled"
                @input="updateInputValue" />
        </template>
    </PhoneInput>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue'
import PhoneInput from 'base-vue-phone-input'
import { useFocus } from '@vueuse/core'
import { ChevronsUpDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
    Popover,
    PopoverContent,
    PopoverTrigger
} from '@/components/ui/popover'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList
} from '@/components/ui/command'
import FlagComponent from './FlagComponent.vue'

interface Props {
    modelValue?: string
    countryCode?: string
    countryLocale?: string
    noUseBrowserLocale?: boolean
    fetchCountry?: boolean
    ignoredCountries?: string[]
    onlyCountries?: string[]
    disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    countryCode: 'IN',
    countryLocale: 'en-EN',
    noUseBrowserLocale: true,
    fetchCountry: false,
    ignoredCountries: () => ['AC'],
    onlyCountries: () => [],
    disabled: false
})

const emit = defineEmits<{
    'update:modelValue': [value: string]
}>()

const open = ref(false)
const phoneInput = ref(null)
const phoneNumber = ref(props.modelValue)
const { focused } = useFocus(phoneInput)

// Watch for external changes to modelValue
watch(
    () => props.modelValue,
    (newValue) => {
        phoneNumber.value = newValue
    }
)

const handleUpdate = (value: string) => {
    emit('update:modelValue', value)
}
</script>
