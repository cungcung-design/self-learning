<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    adventure: Object,
});

const form = useForm({
    adventure_id: props.adventure.id,
    booking_date: "",
    participants: 1,
});

const submit = () => {
    form.post(route("bookings.store"));
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
                    class="w-full h-[450px] rounded-3xl bg-green-50 flex items-center justify-center text-8xl shadow-inner"
                >
                    🏔️
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Left Column: Adventure Info (Spans 2 columns) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Title & Category -->
                    <div>
                        <span
                            class="text-green-700 font-semibold uppercase tracking-wider text-sm bg-green-50 px-3 py-1 rounded-full"
                        >
                            {{ adventure.category?.name }}
                        </span>
                        <h1
                            class="text-4xl lg:text-5xl font-extrabold text-slate-900 mt-3"
                        >
                            {{ adventure.title }}
                        </h1>
                    </div>

                    <!-- Meta Info Badges (Location, Duration, Max People) -->
                    <div
                        class="grid grid-cols-3 gap-4 text-gray-700 bg-stone-50 p-5 rounded-2xl border border-stone-100 text-center"
                    >
                        <div>
                            <p
                                class="text-xs text-gray-400 uppercase font-semibold"
                            >
                                Location
                            </p>
                            <p class="font-bold mt-1">
                                📍 {{ adventure.location }}
                            </p>
                        </div>
                        <div class="border-x border-stone-200">
                            <p
                                class="text-xs text-gray-400 uppercase font-semibold"
                            >
                                Duration
                            </p>
                            <p class="font-bold mt-1">
                                🕒 {{ adventure.duration }} Days
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-gray-400 uppercase font-semibold"
                            >
                                Group Size
                            </p>
                            <p class="font-bold mt-1">
                                👥 Max {{ adventure.max_people }}
                            </p>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="space-y-3">
                        <h2 class="text-2xl font-bold text-slate-800">
                            About This Adventure
                        </h2>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ adventure.description }}
                        </p>
                    </div>

                    <!-- What's Included Section -->
                    <div class="space-y-4 pt-4 border-t border-stone-100">
                        <h3 class="text-2xl font-bold text-slate-800">
                            What's Included
                        </h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div
                                class="flex items-center gap-3 bg-white p-4 rounded-xl border border-stone-100 shadow-sm"
                            >
                                <span
                                    class="text-green-600 bg-green-50 p-2 rounded-lg font-bold"
                                    >✓</span
                                >
                                <span class="font-medium text-slate-700"
                                    >Professional Guide</span
                                >
                            </div>
                            <div
                                class="flex items-center gap-3 bg-white p-4 rounded-xl border border-stone-100 shadow-sm"
                            >
                                <span
                                    class="text-green-600 bg-green-50 p-2 rounded-lg font-bold"
                                    >✓</span
                                >
                                <span class="font-medium text-slate-700"
                                    >Meals & Refreshments</span
                                >
                            </div>
                            <div
                                class="flex items-center gap-3 bg-white p-4 rounded-xl border border-stone-100 shadow-sm"
                            >
                                <span
                                    class="text-green-600 bg-green-50 p-2 rounded-lg font-bold"
                                    >✓</span
                                >
                                <span class="font-medium text-slate-700"
                                    >Transportation Support</span
                                >
                            </div>
                            <!-- Dynamic check if saved via database JSON -->
                            <template
                                v-if="
                                    adventure.included &&
                                    Array.isArray(adventure.included)
                                "
                            >
                                <div
                                    v-for="(item, index) in adventure.included"
                                    :key="index"
                                    class="flex items-center gap-3 bg-white p-4 rounded-xl border border-stone-100 shadow-sm"
                                >
                                    <span
                                        class="text-green-600 bg-green-50 p-2 rounded-lg font-bold"
                                        >✓</span
                                    >
                                    <span class="font-medium text-slate-700">{{
                                        item
                                    }}</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Booking Card Sidebar -->
                <div>
                    <div
                        class="bg-white shadow-xl rounded-3xl p-8 border border-stone-100 sticky top-24"
                    >
                        <!-- Price Tag -->
                        <div
                            class="flex justify-between items-center mb-6 pb-6 border-b border-stone-100"
                        >
                            <div>
                                <p class="text-sm text-gray-400">
                                    Price per person
                                </p>
                                <p
                                    class="text-3xl font-extrabold text-green-700"
                                >
                                    RM {{ adventure.price }}
                                </p>
                            </div>
                        </div>

                        <!-- Booking Form -->
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 mb-2 text-sm"
                                >
                                    Booking Date
                                </label>
                                <input
                                    type="date"
                                    v-model="form.booking_date"
                                    class="w-full border-stone-200 rounded-xl p-3 focus:ring-green-600 focus:border-green-600 text-sm shadow-sm"
                                />
                                <div
                                    v-if="form.errors.booking_date"
                                    class="text-red-500 text-xs mt-1"
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
                                    class="w-full border-stone-200 rounded-xl p-3 focus:ring-green-600 focus:border-green-600 text-sm shadow-sm"
                                />
                                <div
                                    v-if="form.errors.participants"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.participants }}
                                </div>
                            </div>

                            <button
                                :disabled="form.processing"
                                class="w-full mt-4 bg-green-700 hover:bg-green-800 text-white font-semibold py-4 rounded-xl shadow-lg transition duration-200 disabled:opacity-50"
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
