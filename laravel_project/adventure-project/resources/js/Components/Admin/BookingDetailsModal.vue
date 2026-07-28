<script setup>
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
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-lg mx-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Booking #{{ booking.id }}</h2>
                <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Customer</span>
                    <span class="font-semibold text-gray-800">{{ booking.user?.name }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Email</span>
                    <span class="font-semibold text-gray-800">{{ booking.user?.email }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Adventure</span>
                    <span class="font-semibold text-gray-800">{{ booking.adventure?.title }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Date</span>
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
            </div>
        </div>
    </div>
</template>