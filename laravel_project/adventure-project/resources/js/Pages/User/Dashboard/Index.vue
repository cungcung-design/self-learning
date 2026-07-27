<script setup>
import DashboardLayout from '@/Layouts/UserDashboardLayout.vue'

defineProps({
    user: Object,
    bookings: Array,
})
</script>

<template>
    <DashboardLayout>
        <!-- Welcome Header -->
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
            Welcome, {{ user.name }} 👋
        </h1>
        <p class="text-sm text-gray-500 mb-10">
            Here is an overview of your adventure bookings and activities.
        </p>

        <!-- Stats Grid -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <!-- Total Bookings -->
            <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-2">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Total Bookings
                </h2>
                <p class="text-4xl font-extrabold text-slate-900">
                    {{ bookings.length }}
                </p>
            </div>

            <!-- Upcoming Trips -->
            <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-2">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Upcoming Trips
                </h2>
                <p class="text-4xl font-extrabold text-green-600">
                    {{ bookings.filter(b => b.status === 'confirmed').length }}
                </p>
            </div>

            <!-- Favorites -->
            <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-2">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Favorites
                </h2>
                <p class="text-3xl font-extrabold text-slate-900 flex items-center gap-2">
                    <span>❤️</span>
                    <span class="text-2xl">0</span>
                </p>
            </div>
        </div>

        <!-- Recent Bookings Section -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                My Bookings
            </h2>
        </div>

        <div v-if="bookings && bookings.length > 0" class="space-y-4">
            <div
                v-for="booking in bookings"
                :key="booking.id"
                class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all hover:shadow-md"
            >
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-900">
                        {{ booking.adventure.title }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 font-medium">
                        <span>📅 {{ booking.booking_date }}</span>
                        <span>👥 {{ booking.participants }} people</span>
                    </div>
                </div>

                <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end pt-4 sm:pt-0 border-t sm:border-0 border-stone-100">
                    <div class="text-right">
                        <span class="text-xs text-gray-400 block sm:hidden">Total</span>
                        <p class="text-xl font-bold text-green-600">
                            RM {{ booking.total_price }}
                        </p>
                    </div>

                    <span
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider"
                        :class="{
                            'bg-yellow-100 text-yellow-700': booking.status === 'pending',
                            'bg-green-100 text-green-700': booking.status === 'confirmed',
                            'bg-red-100 text-red-700': booking.status === 'cancelled',
                        }"
                    >
                        {{ booking.status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div
            v-else
            class="text-center py-20 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
        >
            <div class="mx-auto w-16 h-16 bg-green-50 text-green-600 flex items-center justify-center rounded-2xl mb-4 shadow-sm text-2xl">
                🎒
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1">
                No bookings found
            </h3>
            <p class="text-sm text-gray-500 max-w-sm mx-auto">
                You haven't booked any adventures yet. Explore our list and start your journey!
            </p>
        </div>
    </DashboardLayout>
</template>