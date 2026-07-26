<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({ bookings: Array });

const form = useForm({});

// Handle booking cancellation (deletes the booking)
const cancelBooking = (id) => {
    if (confirm("Are you sure you want to delete this booking?")) {
        form.delete(route("user.bookings.destroy", id), {
            preserveScroll: true,
        });
    }
};

// Helper to format currency
const formatCurrency = (amount) => {
    if (!amount && amount !== 0) return "-";
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(amount);
};

// Helper to style booking statuses dynamically
const getStatusBadge = (status) => {
    switch (status?.toLowerCase()) {
        case "confirmed":
            return "bg-emerald-50 text-emerald-700 border-emerald-200";
        case "pending":
            return "bg-amber-50 text-amber-700 border-amber-200";
        case "cancelled":
            return "bg-rose-50 text-rose-700 border-rose-200";
        default:
            return "bg-gray-50 text-gray-700 border-gray-200";
    }
};
</script>

<template>
    <MainLayout>
        <template >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-gray-900">
                        My Bookings
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Manage and track all your booked adventures.
                    </p>
                </div>
                <Link
                    :href="route('adventures.index')"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-xl transition duration-150 text-sm shadow-sm hover:shadow"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>
                    Book New Adventure
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white border border-gray-100 shadow-sm sm:rounded-2xl">
                    
                    <!-- Table Header & Add New Booking Button Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <h3 class="text-base font-semibold text-gray-900">
                                All Bookings
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ bookings.length }}
                                {{ bookings.length === 1 ? "Booking" : "Bookings" }}
                            </span>
                        </div>

                        <!-- Top-Right Action Button to Create/Book New -->
                        <Link
                            :href="route('adventures.index')"
                            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-xl transition duration-150 text-xs shadow-sm hover:shadow"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            New Booking
                        </Link>
                    </div>

                    <!-- Bookings Table -->
                    <div v-if="bookings.length > 0" class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                            <thead class="text-xs tracking-wider text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">Adventure</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Date</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">People</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Total</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Status</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="booking in bookings" :key="booking.id" class="transition-colors hover:bg-gray-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img
                                                :src="booking.adventure?.image || booking.image || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&q=80&w=120'"
                                                alt="Adventure preview"
                                                class="object-cover w-12 h-12 border border-gray-200 shadow-sm rounded-xl shrink-0"
                                            />
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ booking.adventure?.title || booking.title || "Adventure #" + booking.id }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5" v-if="booking.adventure?.location">
                                                    {{ booking.adventure.location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ booking.date || booking.created_at }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-700">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            {{ booking.guests || booking.people || booking.participants || 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ formatCurrency(booking.total_price || booking.total_amount || booking.price) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span :class="['px-2.5 py-1 text-xs font-semibold rounded-full border inline-block capitalize', getStatusBadge(booking.status)]">
                                            {{ booking.status || "Confirmed" }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-3 text-right">
                                        <Link
                                            v-if="booking.adventure?.id"
                                            :href="route('adventures.show', booking.adventure.id)"
                                            class="text-emerald-600 hover:text-emerald-900 font-medium text-xs bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition"
                                        >
                                            View
                                        </Link>
                                        <button
                                            v-if="booking.status?.toLowerCase() !== 'cancelled'"
                                            @click="cancelBooking(booking.id)"
                                            class="text-rose-600 hover:text-rose-900 font-medium text-xs bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                        >
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="px-6 py-16 text-center">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 shadow-sm bg-emerald-50 text-emerald-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.5 3.75H6.75A2.25 2.25 0 014.5 18.75V5.25A2.25 2.25 0 016.75 3h10.5A2.25 2.25 0 0119.5 5.25v13.5A2.25 2.25 0 0117.25 21z" />
                            </svg>
                        </div>
                        <h3 class="mb-1 text-base font-semibold text-gray-900">No bookings yet</h3>
                        <p class="max-w-sm mx-auto mb-6 text-sm text-gray-500">You haven't booked any adventures yet. Explore our catalog and reserve your next experience today!</p>
                        <Link
                            :href="route('adventures.index')"
                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-xl transition shadow-sm text-sm"
                        >
                            Explore Adventures
                        </Link>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>