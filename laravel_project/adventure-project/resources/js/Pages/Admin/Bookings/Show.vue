<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BookingStatusBadge from '@/Components/Admin/BookingStatusBadge.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    booking: Object
});

const updateStatus = (status) => {
    router.patch(route('admin.bookings.' + status, props.booking.id), {}, {
        preserveScroll: true
    });
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow p-8">
            <div class="flex justify-between items-center pb-6 border-b border-gray-100 mb-6">
                <h1 class="text-xl font-bold text-gray-800">Booking #{{ booking.id }}</h1>
                <BookingStatusBadge :status="booking.status" />
            </div>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Customer Name</span>
                    <span class="font-semibold text-gray-800">{{ booking.user?.name }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Email Address</span>
                    <span class="font-semibold text-gray-800">{{ booking.user?.email }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Adventure Package</span>
                    <span class="font-semibold text-gray-800">{{ booking.adventure?.title }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Booking Date</span>
                    <span class="font-semibold text-gray-800">{{ booking.booking_date }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Participants</span>
                    <span class="font-semibold text-gray-800">{{ booking.participants }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Total Price</span>
                    <span class="font-bold text-gray-900">RM {{ booking.adventure?.price * booking.participants }}</span>
                </div>
                <div v-if="booking.payment" class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Payment Method</span>
                    <span class="font-semibold text-gray-800 capitalize">{{ booking.payment.payment_method }}</span>
                </div>
                <div v-if="booking.payment" class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Transaction ID</span>
                    <span class="font-semibold text-gray-800">{{ booking.payment.transaction_id || '-' }}</span>
                </div>
                <div v-if="booking.payment" class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Payment Status</span>
                    <span class="font-semibold text-gray-800 capitalize">{{ booking.payment.status }}</span>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button 
                    v-if="booking.status !== 'confirmed'"
                    @click="updateStatus('confirm')" 
                    class="flex-1 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition text-center">
                    Confirm Booking
                </button>
                <button 
                    v-if="booking.status !== 'cancelled'"
                    @click="updateStatus('cancel')" 
                    class="flex-1 py-3 bg-red-50 text-red-600 rounded-xl font-semibold hover:bg-red-100 transition text-center">
                    Cancel Booking
                </button>
                <a
                    v-if="['confirmed','paid','completed'].includes(booking.status?.toLowerCase())"
                    :href="route('invoice.download', booking.id)"
                    class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition text-center text-center">
                    Download Invoice
                </a>
            </div>
        </div>
    </AdminLayout>
</template>