<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DashboardCard from '@/Components/Admin/DashboardCard.vue';

defineProps({
    totalUsers: Number,
    totalBookings: Number,
    totalRevenue: Number,
    popularAdventures: Array,
    bookingStatus: Object,
    monthlyRevenue: Array
});
</script>

<template>
    <AdminLayout>
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">📊 Reports & Analytics</h1>

            <div class="flex gap-3">
                <a :href="route('admin.reports.pdf')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                    📄 Export PDF
                </a>
                <a :href="route('admin.reports.excel')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                    📊 Export Excel
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <DashboardCard title="Total Users" :value="totalUsers" icon="👥" color="border-purple-500" />
            <DashboardCard title="Total Bookings" :value="totalBookings" icon="📅" color="border-blue-500" />
            <DashboardCard title="Total Revenue" :value="'RM ' + totalRevenue" icon="💰" color="border-yellow-500" />
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-bold text-lg text-gray-800 mb-4">🏆 Popular Adventures</h2>
                <div class="space-y-4">
                    <div v-for="(item, index) in popularAdventures" :key="item.id" class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                        <span class="font-medium text-gray-700">{{ index + 1 }}. {{ item.title }}</span>
                        <span class="text-xs bg-gray-100 px-2.5 py-1 rounded-full font-semibold text-gray-600">{{ item.bookings_count }} bookings</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-bold text-lg text-gray-800 mb-4">📊 Booking Status Overview</h2>
                <div class="space-y-3">
                    <div v-for="(count, status) in bookingStatus" :key="status" class="flex justify-between items-center capitalize bg-gray-50 p-3 rounded-xl">
                        <span class="font-medium text-gray-600">{{ status }}</span>
                        <span class="font-bold text-gray-800">{{ count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
