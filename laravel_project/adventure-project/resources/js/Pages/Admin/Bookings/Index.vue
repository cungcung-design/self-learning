<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { router } from "@inertiajs/vue3";
import {
    CheckCircleIcon,
    ClockIcon,
    XCircleIcon,
    CheckIcon,
    XMarkIcon,
    TrashIcon,
    BookmarkSquareIcon,
    MapPinIcon,
    CalendarDaysIcon,
    UsersIcon,
} from "@heroicons/vue/24/outline";

defineProps({ bookings: Array });

function confirmBooking(id) {
    if (confirm("Are you sure you want to confirm this booking?")) {
        router.patch(
            route("admin.bookings.confirm", id),
            {},
            { preserveScroll: true },
        );
    }
}

function cancelBooking(id) {
    if (confirm("Are you sure you want to cancel this booking?")) {
        router.patch(
            route("admin.bookings.cancel", id),
            {},
            { preserveScroll: true },
        );
    }
}

function deleteBooking(id) {
    if (
        confirm(
            "Are you sure you want to completely delete this booking record?",
        )
    ) {
        router.delete(route("admin.bookings.destroy", id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
            <!-- Page Header -->
            <div
                class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4"
            >
                <div>
                    <span
                        class="bg-green-100 text-green-800 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full inline-block mb-2"
                    >
                        Control Center
                    </span>
                    <h1
                        class="text-4xl font-extrabold text-slate-900 tracking-tight"
                    >
                        Booking Management
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Review, approve, or cancel incoming customer reservation
                        requests.
                    </p>
                </div>
            </div>

            <!-- Table Container Card -->
            <div
                class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider"
                        >
                            <tr>
                                <th class="p-5 font-bold">Customer</th>
                                <th class="p-5 font-bold">Adventure</th>
                                <th class="p-5 font-bold">Schedule</th>
                                <th class="p-5 font-bold">Travelers</th>
                                <th class="p-5 font-bold">Status</th>
                                <th class="p-5 font-bold text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 text-sm">
                            <tr
                                v-for="booking in bookings"
                                :key="booking.id"
                                class="hover:bg-slate-50/50 transition"
                            >
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-700 font-bold shrink-0"
                                        >
                                            {{
                                                booking.user?.name
                                                    ? booking.user.name
                                                          .charAt(0)
                                                          .toUpperCase()
                                                    : "U"
                                            }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">
                                                {{
                                                    booking.user?.name ||
                                                    "Unknown User"
                                                }}
                                            </p>
                                            <p class="text-xs text-slate-400">
                                                {{
                                                    booking.user?.email ||
                                                    "No email provided"
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-5">
                                    <span
                                        class="font-bold text-slate-800 block"
                                        >{{
                                            booking.adventure?.title ||
                                            "Adventure Removed"
                                        }}</span
                                    >
                                    <span
                                        class="text-xs text-slate-400 flex items-center gap-1 mt-0.5"
                                        v-if="booking.adventure?.location"
                                    >
                                        <MapPinIcon class="w-3.5 h-3.5" />
                                        {{ booking.adventure.location }}
                                    </span>
                                </td>

                                <td
                                    class="p-5 text-slate-600 font-medium whitespace-nowrap"
                                >
                                    <div class="flex items-center gap-1.5">
                                        <CalendarDaysIcon
                                            class="w-4 h-4 text-slate-400"
                                        />
                                        {{ booking.booking_date }}
                                    </div>
                                </td>

                                <td
                                    class="p-5 text-slate-600 font-medium whitespace-nowrap"
                                >
                                    <div class="flex items-center gap-1.5">
                                        <UsersIcon
                                            class="w-4 h-4 text-slate-400"
                                        />
                                        {{ booking.participants }}
                                        {{
                                            booking.participants > 1
                                                ? "people"
                                                : "person"
                                        }}
                                    </div>
                                </td>

                                <td class="p-5">
                                    <span
                                        v-if="booking.status === 'pending'"
                                        class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3.5 py-1.5 rounded-xl text-xs font-bold border border-amber-100 shadow-sm"
                                    >
                                        <ClockIcon class="w-4 h-4" /> Pending
                                    </span>
                                    <span
                                        v-else-if="
                                            booking.status === 'confirmed'
                                        "
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3.5 py-1.5 rounded-xl text-xs font-bold border border-emerald-100 shadow-sm"
                                    >
                                        <CheckCircleIcon class="w-4 h-4" />
                                        Confirmed
                                    </span>
                                    <span
                                        v-else-if="
                                            booking.status === 'cancelled'
                                        "
                                        class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3.5 py-1.5 rounded-xl text-xs font-bold border border-rose-100 shadow-sm"
                                    >
                                        <XCircleIcon class="w-4 h-4" />
                                        Cancelled
                                    </span>
                                </td>

                                <td
                                    class="p-5 text-right space-x-2 whitespace-nowrap"
                                >
                                    <button
                                        v-if="booking.status !== 'confirmed'"
                                        @click="confirmBooking(booking.id)"
                                        class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold px-3.5 py-2 rounded-xl transition text-xs shadow-sm"
                                        title="Approve & Confirm"
                                    >
                                        <CheckIcon class="w-4 h-4" /> Confirm
                                    </button>
                                    <button
                                        v-if="booking.status !== 'cancelled'"
                                        @click="cancelBooking(booking.id)"
                                        class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold px-3.5 py-2 rounded-xl transition text-xs shadow-sm"
                                        title="Cancel Booking"
                                    >
                                        <XMarkIcon class="w-4 h-4" /> Cancel
                                    </button>
                                    <button
                                        @click="deleteBooking(booking.id)"
                                        class="inline-flex items-center gap-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold p-2 rounded-xl transition text-xs shadow-sm"
                                        title="Delete Permanently"
                                    >
                                        <TrashIcon class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="bookings.length === 0">
                                <td colspan="6" class="p-20 text-center">
                                    <div
                                        class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100"
                                    >
                                        <BookmarkSquareIcon
                                            class="w-10 h-10 text-slate-300"
                                        />
                                    </div>
                                    <p
                                        class="text-xl font-bold text-slate-800 mb-1"
                                    >
                                        No booking requests found
                                    </p>
                                    <p class="text-slate-400 text-sm">
                                        When users reserve adventures, they will
                                        appear right here.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
