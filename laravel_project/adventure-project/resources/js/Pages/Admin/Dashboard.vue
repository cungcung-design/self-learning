<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DashboardCard from '@/Components/Admin/DashboardCard.vue';
import LatestReviews from '@/Components/Admin/LatestReviews.vue';
import RevenueChart from '@/Components/Admin/Charts/RevenueChart.vue';
import BookingStatusChart from '@/Components/Admin/Charts/BookingStatusChart.vue';

defineProps({
    adventures: Number,
    bookings: Number,
    users: Number,
    revenue: Number,
    revenueLabels: Array,
    revenueValues: Array,
    bookingStats: Object,
    topAdventures: Array,
    recentBookings: Array,
    latestReviews: Array,
});
</script>

<template>
    <AdminLayout>
        <!-- Quick Actions Panel -->
        <div class="bg-white rounded-2xl shadow p-4 mb-8 flex flex-wrap gap-4 items-center justify-between">
            <span class="font-bold text-gray-700">Quick Actions</span>
            <div class="flex flex-wrap gap-3">
                <a href="/admin/adventures/create" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">➕ Add Adventure</a>
                <a href="/admin/categories/create" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">📂 Add Category</a>
                <a href="/admin/bookings" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">📅 View Bookings</a>
                <a href="/admin/reports" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">📊 Generate Report</a>
            </div>
        </div>

        <!-- KPI Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <DashboardCard title="Adventures" :value="adventures" icon="🏔" color="border-green-500" />
            <DashboardCard title="Bookings" :value="bookings" icon="📅" color="border-blue-500" />
            <DashboardCard title="Users" :value="users" icon="👥" color="border-purple-500" />
            <DashboardCard title="Revenue" :value="'RM ' + revenue" icon="💰" color="border-yellow-500" />
        </div>

        <!-- Charts Section -->
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <RevenueChart :labels="revenueLabels" :values="revenueValues" />
            <BookingStatusChart :stats="bookingStats" />
        </div>

        <!-- Secondary Information Panels -->
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Adventures -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Top Adventures</h3>
                <div class="space-y-4">
                    <div v-for="(adv, index) in topAdventures" :key="adv.id" class="flex justify-between items-center border-b border-gray-100 pb-3 last:border-0">
                        <span class="font-medium text-gray-700">
                            {{ index === 0 ? '🥇' : index === 1 ? '🥈' : '🥉' }} {{ adv.title }}
                        </span>
                        <span class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-semibold">{{ adv.bookings_count }} Bookings</span>
                    </div>
                </div>
            </div>

            <!-- Latest Bookings -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Latest Bookings</h3>
                <div class="space-y-4">
                    <div v-for="booking in recentBookings" :key="booking.id" class="flex justify-between items-center border-b border-gray-100 pb-3 last:border-0">
                        <span class="font-medium text-gray-700">{{ booking.user?.name }} - {{ booking.adventure?.title }}</span>
                        <span class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full font-semibold uppercase">{{ booking.status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <LatestReviews :reviews="latestReviews" />
    </AdminLayout>
</template>