<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";
import AvailabilityCalendar from "../Bookings/AvailabilityCalendar.vue";

const props = defineProps({
    adventure: Object,
});

const form = useForm({
    adventure_id: props.adventure?.id,
    booking_date: "",
    participants: 1,
});

const submit = () => {
    // Submit only the booking form
    form.post(route("user.bookings.store"));
};
</script>

<template>
    <MainLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- Hero Image Banner -->
            <div class="mb-10">
                <img
                    v-if="adventure.image"
                    :src="'/storage/' + adventure.image"
                    :alt="adventure.title"
                    class="w-full h-[450px] object-cover rounded-3xl shadow-md"
                />
                <div
                    v-else
                    class="w-full h-[450px] rounded-3xl bg-green-50 flex items-center justify-center text-8xl shadow-inner border border-green-100"
                >
                    🏔️
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-10">
                    <div>
                        <span
                            class="text-green-700 font-semibold uppercase tracking-wider text-sm bg-green-50 px-3 py-1 rounded-full"
                        >
                            {{ adventure.category?.name || "Adventure" }}
                        </span>
                        <h1
                            class="text-4xl lg:text-5xl font-extrabold text-slate-900 mt-4 leading-tight"
                        >
                            {{ adventure.title }}
                        </h1>
                    </div>

                    <div
                        class="grid grid-cols-3 gap-4 text-gray-700 bg-stone-50 p-6 rounded-2xl border border-stone-100 text-center shadow-sm"
                    >
                        <div>
                            <p
                                class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1"
                            >
                                Location
                            </p>
                            <p class="font-semibold text-slate-800">
                                📍 {{ adventure.location }}
                            </p>
                        </div>
                        <div class="border-x border-stone-200">
                            <p
                                class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1"
                            >
                                Duration
                            </p>
                            <p class="font-semibold text-slate-800">
                                🕒 {{ adventure.duration }} Days
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1"
                            >
                                Group Size
                            </p>
                            <p class="font-semibold text-slate-800">
                                👥 Max {{ adventure.max_people }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-slate-900">
                            About This Adventure
                        </h2>
                        <p
                            class="text-gray-600 leading-relaxed text-lg whitespace-pre-line"
                        >
                            {{ adventure.description }}
                        </p>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Booking Sidebar -->
                <div class="relative">
                    <div
                        class="bg-white shadow-xl rounded-3xl p-8 border border-stone-100 sticky top-8"
                    >
                        <div
                            class="flex justify-between items-end mb-6 pb-6 border-b border-stone-100"
                        >
                            <div>
                                <p
                                    class="text-sm text-gray-500 font-medium mb-1"
                                >
                                    Price per person
                                </p>
                                <p
                                    class="text-3xl font-extrabold text-green-700"
                                >
                                    RM {{ adventure.price }}
                                </p>
                            </div>
                        </div>

                        <!-- Availability Calendar Component bound to form date -->
                        <AvailabilityCalendar
                            :adventureId="adventure.id"
                            @update:bookingDate="
                                (date) => (form.booking_date = date)
                            "
                        />

                        <!-- Booking Form -->
                        <form @submit.prevent="submit" class="space-y-5">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 mb-2 text-sm"
                                >
                                    Selected Booking Date
                                </label>
                                <input
                                    type="text"
                                    readonly
                                    v-model="form.booking_date"
                                    placeholder="Please select from calendar above"
                                    class="w-full bg-stone-50 border-stone-200 rounded-xl p-3 text-sm shadow-sm cursor-not-allowed"
                                />
                                <div
                                    v-if="form.errors.booking_date"
                                    class="text-rose-500 text-xs mt-1.5 font-medium"
                                >
                                    {{ form.errors.booking_date }}
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block font-semibold text-slate-700 mb-2 text-sm"
                                >
                                    Participants
                                </label>
                                <input
                                    type="number"
                                    min="1"
                                    v-model="form.participants"
                                    class="w-full border-stone-200 rounded-xl p-3 focus:ring-green-600 focus:border-green-600 text-sm shadow-sm transition"
                                />
                                <div
                                    v-if="form.errors.participants"
                                    class="text-rose-500 text-xs mt-1.5 font-medium"
                                >
                                    {{ form.errors.participants }}
                                </div>
                            </div>

                            <div
                                class="flex justify-between items-center py-3 text-sm font-semibold text-slate-700"
                            >
                                <span>Total Estimate</span>
                                <span
                                    >RM
                                    {{
                                        adventure.price * form.participants || 0
                                    }}</span
                                >
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-700/20 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{
                                    form.processing
                                        ? "Processing..."
                                        : "Book Now"
                                }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
