<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const stats = ref([
    { value: 0, target: 5000, label: 'Happy Clients', prefix: '', suffix: '+' },
    { value: 0, target: 15000, label: 'Appointments Booked', prefix: '', suffix: '+' },
    { value: 0, target: 99, label: 'Satisfaction Rate', prefix: '', suffix: '%' },
]);

const animateStats = () => {
    stats.value.forEach((stat, index) => {
        const increment = stat.target / 100;
        const timer = setInterval(
            () => {
                if (stat.value < stat.target) {
                    stat.value += increment;
                    if (stat.value > stat.target) stat.value = stat.target;
                } else {
                    clearInterval(timer);
                }
            },
            20 + index * 10,
        );
    });
};

onMounted(() => {
    setTimeout(animateStats, 500);
});
</script>

<template>
    <Head title="Welcome - QuickSlot Booking">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div
        class="min-h-screen overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/30"
    >
        <!-- Animated background elements -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 h-80 w-80 animate-pulse rounded-full bg-gradient-to-br from-blue-400/20 to-indigo-500/20 blur-3xl"
            ></div>
            <div
                class="absolute top-1/2 -left-40 h-96 w-96 animate-pulse rounded-full bg-gradient-to-tr from-green-400/20 to-blue-500/20 blur-3xl"
                style="animation-delay: 1s"
            ></div>
            <div
                class="absolute right-1/4 -bottom-40 h-64 w-64 animate-pulse rounded-full bg-gradient-to-tl from-purple-400/20 to-pink-500/20 blur-3xl"
                style="animation-delay: 2s"
            ></div>
        </div>

        <div class="relative flex min-h-screen flex-col items-center p-6 text-gray-800 lg:justify-center lg:p-8 dark:text-gray-100">
            <!-- Header -->
            <header class="mb-12 w-full max-w-7xl">
                <nav class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg"
                            >
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 h-4 w-4 animate-ping rounded-full bg-green-400"></div>
                        </div>
                        <span
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-2xl font-bold text-transparent dark:from-blue-400 dark:to-indigo-400"
                        >
                            QuickSlot
                        </span>
                    </div>

                    <!-- Navigation -->
                    <div class="flex items-center gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard.index')"
                            class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-sm font-medium text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"
                                />
                            </svg>
                            Dashboard
                            <div
                                class="absolute inset-0 rounded-xl bg-white/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            ></div>
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="inline-flex items-center rounded-xl border border-gray-300 px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-300 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 dark:border-gray-600 dark:text-gray-300 dark:hover:border-blue-500 dark:hover:bg-blue-900/20 dark:hover:text-blue-400"
                            >
                                Log in
                            </Link>
                        </template>
                    </div>
                </nav>
            </header>

            <!-- Main Content -->
            <div class="fade-in-up flex w-full items-center justify-center opacity-0">
                <main class="flex w-full max-w-7xl flex-col lg:flex-row lg:items-center lg:gap-16">
                    <!-- Left Content -->
                    <div class="flex-1 space-y-8 lg:space-y-12">
                        <!-- Hero Section -->
                        <div class="space-y-6">
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-sm font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"
                            >
                                <div class="h-2 w-2 animate-pulse rounded-full bg-green-500"></div>
                                Real-Time Availability • Instant Booking
                            </div>

                            <h1 class="text-4xl leading-tight font-bold lg:text-6xl">
                                <span
                                    class="bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-white dark:to-gray-300"
                                >
                                    Book Your Appointment
                                </span>
                                <br />
                                <span class="animate-pulse bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                    In Seconds
                                </span>
                            </h1>

                            <p class="max-w-2xl text-xl leading-relaxed text-gray-600 dark:text-gray-300">
                                Effortlessly schedule appointments with our smart booking system. View available time slots, choose your preferred service, and confirm your booking instantly. No hassle, no waiting.
                            </p>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                                <Link
                                    :href="route('bookings.index')"
                                    class="group inline-flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Book Now
                                    <div
                                        class="absolute inset-0 rounded-xl bg-white/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                    ></div>
                                </Link>
                                <button
                                    class="group inline-flex items-center justify-center gap-3 rounded-xl border-2 border-gray-300 px-8 py-4 text-lg font-semibold text-gray-700 transition-all duration-300 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 dark:border-gray-600 dark:text-gray-300 dark:hover:border-blue-400 dark:hover:bg-blue-900/20 dark:hover:text-blue-400"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    View Hours
                                </button>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="grid grid-cols-3 gap-8 border-t border-gray-200 pt-8 dark:border-gray-700">
                            <div
                                v-for="(stat, index) in stats"
                                :key="index"
                                class="transform text-center transition-all duration-500 hover:scale-110"
                            >
                                <div
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-2xl font-bold text-transparent lg:text-3xl"
                                >
                                    {{ stat.prefix }}{{ Math.floor(stat.value).toLocaleString() }}{{ stat.suffix }}
                                </div>
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ stat.label }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Booking Preview -->
                    <div class="mt-12 flex-1 lg:mt-0">
                        <div class="relative">
                            <!-- Floating Cards Animation -->
                            <div class="relative mx-auto max-w-md">
                                <!-- Main Booking Card -->
                                <div class="floating-card relative z-10 rounded-2xl bg-white/80 p-6 shadow-2xl backdrop-blur-sm dark:bg-gray-800/80">
                                    <div class="mb-4 flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Available Today</h3>
                                        <div class="h-3 w-3 animate-pulse rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Next Available</span>
                                            <span class="text-xl font-bold text-blue-600">2:00 PM</span>
                                        </div>
                                        
                                        <!-- Time Slots -->
                                        <div class="space-y-2">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Select a time slot:</div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <button class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-400 dark:border-gray-600 dark:bg-gray-700/50 line-through">
                                                    9:00 AM
                                                </button>
                                                <button class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-400 dark:border-gray-600 dark:bg-gray-700/50 line-through">
                                                    10:00 AM
                                                </button>
                                                <button class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 dark:border-blue-500 dark:bg-blue-900/30 dark:text-blue-300">
                                                    2:00 PM
                                                </button>
                                                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                                    3:00 PM
                                                </button>
                                                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                                    4:00 PM
                                                </button>
                                                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                                    5:00 PM
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Services -->
                                        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <div class="rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="text-xs text-purple-600 dark:text-purple-400">Haircut</div>
                                                </div>
                                                <div class="text-sm font-bold text-purple-700 dark:text-purple-300">30 min</div>
                                            </div>
                                            <div class="rounded-lg bg-green-50 p-3 dark:bg-green-900/20">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <div class="text-xs text-green-600 dark:text-green-400">Massage</div>
                                                </div>
                                                <div class="text-sm font-bold text-green-700 dark:text-green-300">60 min</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Floating Availability Card -->
                                <div
                                    class="floating-card-reverse absolute -top-6 -right-6 z-20 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 p-4 text-white shadow-lg"
                                >
                                    <div class="text-xs opacity-90">Open Slots</div>
                                    <div class="text-2xl font-bold">12</div>
                                    <div class="text-xs opacity-75">Today</div>
                                </div>

                                <!-- Floating Status Card -->
                                <div
                                    class="floating-card-slow absolute -bottom-4 -left-8 z-20 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 p-4 text-white shadow-lg"
                                >
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-2 animate-pulse rounded-full bg-white"></div>
                                        <div class="text-xs opacity-90">Status</div>
                                    </div>
                                    <div class="text-lg font-bold mt-1">Open Now</div>
                                    <div class="text-xs opacity-75">9 AM - 6 PM</div>
                                </div>

                                <!-- Background Glow -->
                                <div
                                    class="absolute inset-0 -z-10 animate-pulse rounded-3xl bg-gradient-to-r from-blue-400/20 to-purple-400/20 blur-3xl"
                                ></div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-in-up {
    animation: fadeInUp 1s ease-out 0.3s forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.floating-card {
    animation: float 6s ease-in-out infinite;
}

.floating-card-reverse {
    animation: float 4s ease-in-out infinite reverse;
}

.floating-card-slow {
    animation: float 5s ease-in-out infinite;
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.progress-bar {
    width: 0%;
    animation: growWidth 2s ease-out 1s forwards;
}

@keyframes growWidth {
    from {
        width: 0%;
    }
    to {
        width: 68%;
    }
}
</style>
