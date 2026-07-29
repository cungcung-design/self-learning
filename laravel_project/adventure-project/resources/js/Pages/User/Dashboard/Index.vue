<script setup>
import { Link } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/UserDashboardLayout.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
    upcomingAdventure: {
        type: Object,
        default: null,
    },
})

const formatDate = (dateStr) => {
    if (!dateStr) return ''
    const date = new Date(dateStr)
    return date.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
}
</script>

<template>
    <DashboardLayout>
        <div>
            <!-- Welcome Header -->
            <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">
                Welcome back, {{ user.name }} 👋
            </h1>
            <p class="text-sm text-gray-500">
                Here is what's happening with your outdoor adventures today.
            </p>
        </div>

        <!-- Stats Row -->
        <div class="flex flex-wrap items-center gap-4 mb-8">
            <Link
                :href="route('user.bookings.index')"
                class="inline-flex items-center gap-2 bg-white border border-stone-200 rounded-xl px-4 py-3 shadow-sm hover:shadow transition text-sm font-semibold text-slate-900"
            >
                <span>📅</span>
                <span>Total Bookings: {{ stats.total_bookings }}</span>
            </Link>

            <div class="inline-flex items-center gap-2 bg-white border border-stone-200 rounded-xl px-4 py-3 shadow-sm text-sm font-semibold text-slate-900">
                <span>🏔</span>
                <span>Upcoming Trips: {{ stats.upcoming_trips }}</span>
            </div>

            <Link
                :href="route('user.favorites.index')"
                class="inline-flex items-center gap-2 bg-white border border-stone-200 rounded-xl px-4 py-3 shadow-sm hover:shadow transition text-sm font-semibold text-slate-900"
            >
                <span>⭐</span>
                <span>Favorites: {{ stats.favorites }}</span>
            </Link>
        </div>

        <!-- Divider -->
        <div class="border-t border-stone-200 mb-8"></div>

        <!-- Upcoming Confirmed Adventure -->
        <h2 class="text-xl font-bold text-slate-900 tracking-tight mb-5">
            Upcoming Confirmed Adventure:
        </h2>

        <div
            v-if="upcomingAdventure"
            class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 max-w-4xl"
        >
            <div class="space-y-4 mb-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    🏔 {{ upcomingAdventure.title }}
                </h3>
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 font-medium">
                    <span class="flex items-center gap-1">
                        📅 Date: {{ formatDate(upcomingAdventure.booking_date) }}
                    </span>
                    <span class="text-stone-300">|</span>
                    <span class="flex items-center gap-1">
                        👥 {{ upcomingAdventure.participants }} Participants
                    </span>
                    <span class="text-stone-300">|</span>
                    <span class="flex items-center gap-1">
                        Status: Confirmed ✅
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    :href="route('invoice.download', upcomingAdventure.id)"
                    class="inline-flex items-center gap-2 bg-slate-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-sm"
                >
                    📄 Download Invoice
                </a>

                <Link
                    :href="route('user.bookings.index')"
                    class="inline-flex items-center gap-2 bg-white border border-stone-200 text-slate-900 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-stone-50 transition shadow-sm"
                >
                    View Booking Details
                </Link>
            </div>
        </div>

        <div
            v-else
            class="text-center py-12 bg-stone-50 rounded-2xl border border-stone-200 border-dashed max-w-4xl"
        >
            <p class="text-sm text-gray-500">
                No upcoming confirmed adventures. Start booking today!
            </p>
            <Link
                href="/adventures"
                class="mt-4 inline-flex text-sm font-semibold text-green-700 hover:text-green-800"
            >
                Browse Adventures →
            </Link>
        </div>
        </div>
    </DashboardLayout>
</template>