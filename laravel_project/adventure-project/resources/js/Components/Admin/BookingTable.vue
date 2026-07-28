<script setup>
import { Link, router } from '@inertiajs/vue3';
import BookingStatusBadge from './BookingStatusBadge.vue';

defineProps({
    bookings: Object
});

const confirmBooking = (id) => {
    router.patch(route('admin.bookings.confirm', id), {}, {
        preserveScroll: true
    });
};

const cancelBooking = (id) => {
    router.patch(route('admin.bookings.cancel', id), {}, {
        preserveScroll: true
    });
};
</script>

<template>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="py-3 px-6">ID</th>
                        <th class="py-3 px-6">Customer</th>
                        <th class="py-3 px-6">Adventure</th>
                        <th class="py-3 px-6">Date</th>
                        <th class="py-3 px-6">People</th>
                        <th class="py-3 px-6">Total</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    <tr v-for="booking in bookings.data" :key="booking.id" class="hover:bg-gray-50/50">
                        <td class="py-4 px-6 font-medium text-gray-800">#{{ booking.id }}</td>
                        <td class="py-4 px-6 font-semibold text-gray-800">{{ booking.user?.name }}</td>
                        <td class="py-4 px-6">{{ booking.adventure?.title }}</td>
                        <td class="py-4 px-6">{{ booking.booking_date }}</td>
                        <td class="py-4 px-6">{{ booking.participants }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">RM {{ booking.adventure?.price * booking.participants }}</td>
                        <td class="py-4 px-6">
                            <BookingStatusBadge :status="booking.status" />
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <Link :href="route('admin.bookings.show', booking.id)" class="text-blue-600 hover:text-blue-800 font-medium">View</Link>
                            <button v-if="booking.status === 'pending'" @click="confirmBooking(booking.id)" class="text-green-600 hover:text-green-800 font-medium">Confirm</button>
                            <button v-if="booking.status !== 'cancelled'" @click="cancelBooking(booking.id)" class="text-red-600 hover:text-red-800 font-medium">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>