<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import PhoneInput from '@/components/ui/PhoneInput.vue';
import { getInitials } from '@/composables/useInitials';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { Camera } from 'lucide-vue-next';
import { onUnmounted, ref, watch } from 'vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = ref(page.props.auth.user);

// Watch for changes in the user object
watch(
    () => page.props.auth.user,
    (newUser) => {
        user.value = newUser;
    },
);

// Form using useForm
const form = useForm({
    first_name: user.value.first_name || '',
    last_name: user.value.last_name || '',
    email: user.value.email || '',
    contact_no: user.value.contact_no || '',
    profile_photo: null as File | null,
});

// Refs
const fileInput = ref<HTMLInputElement>();
const previewImage = ref<string | null>(null);

// Methods
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        // Revoke previous preview URL to prevent memory leaks
        if (previewImage.value) {
            URL.revokeObjectURL(previewImage.value);
        }

        // Create preview URL for the selected image
        previewImage.value = URL.createObjectURL(file);
        form.profile_photo = file;
    }
};

const submit = () => {
    form.post(route('profile.update'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            // Clear the file input
            if (fileInput.value) {
                fileInput.value.value = '';
            }
            form.profile_photo = null;

            // Lazy load only the auth user data without full page reload
            router.reload({
                only: ['auth'],
                onSuccess: () => {
                    previewImage.value = user.value.profile_picture || null;
                },
            });
        },
    });
};

// Cleanup preview URL when component is unmounted
onUnmounted(() => {
    if (previewImage.value) {
        URL.revokeObjectURL(previewImage.value);
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Update your personal information including name, email, and contact details" />

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Profile Photo Section -->
                    <div class="space-y-4">
                        <h3 class="border-b border-border/50 pb-2 text-sm font-semibold text-foreground">Profile Photo</h3>
                        <div class="flex items-center gap-4 rounded-lg bg-muted/50 p-4">
                            <div class="relative">
                                <Avatar class="h-16 w-16">
                                    <AvatarImage
                                        v-if="previewImage || user.profile_picture"
                                        :src="previewImage || user.profile_picture || ''"
                                        :alt="user.first_name + ' ' + user.last_name"
                                    />
                                    <AvatarFallback class="text-lg font-semibold">
                                        {{ getInitials(user.first_name + ' ' + user.last_name) }}
                                    </AvatarFallback>
                                </Avatar>
                                <button
                                    type="button"
                                    class="absolute -right-1 -bottom-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary text-primary-foreground transition-colors hover:bg-primary/90"
                                    @click="fileInput?.click()"
                                >
                                    <Camera class="h-3 w-3" />
                                </button>
                                <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="handleFileUpload" />
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-medium">Profile Photo</p>
                                <p class="text-xs text-muted-foreground">
                                    Click the camera icon to upload a profile photo. Recommended size: 200x200px
                                </p>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.profile_photo" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <Label for="first_name">First Name</Label>
                            <Input
                                id="first_name"
                                class="mt-1 block w-full"
                                v-model="form.first_name"
                                required
                                autocomplete="given-name"
                                placeholder="First name"
                            />
                            <InputError class="mt-2" :message="form.errors.first_name" />
                        </div>
                        <div>
                            <Label for="last_name">Last Name</Label>
                            <Input
                                id="last_name"
                                class="mt-1 block w-full"
                                v-model="form.last_name"
                                required
                                autocomplete="family-name"
                                placeholder="Last name"
                            />
                            <InputError class="mt-2" :message="form.errors.last_name" />
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="contact_no">Contact Number</Label>
                        <PhoneInput v-model="form.contact_no" country-code="IN" :only-countries="['IN']" :disabled="form.processing" class="mt-1" />
                        <InputError class="mt-2" :message="form.errors.contact_no" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button type="submit" :disabled="form.processing">
                            {{ form.processing ? 'Saving...' : 'Save' }}
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
