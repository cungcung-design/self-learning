<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    booking: Object,
    payment: Object, // Added since we passed it in the controller earlier
});

const form = useForm({
    payment_id: props.payment?.id,
});

const payNow = () => {
    // Post to a payment process route
    form.post(route("user.payment.process", props.booking.id));
};
</script>

<template>
    <MainLayout>
        <div class="max-w-xl px-6 mx-auto mt-10">
            <h1 class="text-3xl font-bold text-slate-800">Payment Checkout</h1>

            <div
                class="p-6 mt-6 bg-white border shadow-md rounded-2xl border-stone-100"
            >
                <h2 class="mb-2 text-xl font-bold text-slate-900">
                    {{ booking.adventure.title }}
                </h2>

                <p class="mb-1 text-gray-600">
                    Booking Date:
                    <span class="font-semibold text-slate-800">{{
                        booking.booking_date
                    }}</span>
                </p>

                <p class="mb-4 text-gray-600">
                    Participants:
                    <span class="font-semibold text-slate-800">{{
                        booking.participants
                    }}</span>
                </p>

                <div
                    class="flex items-center justify-between pt-4 mt-4 border-t border-stone-100"
                >
                    <span class="font-medium text-gray-500">Total Amount</span>
                    <span class="text-2xl font-extrabold text-green-700">
                        RM {{ booking.participants * booking.adventure.price }}
                    </span>
                </div>

                <button
                    @click="payNow"
                    :disabled="form.processing"
                    class="w-full bg-green-700 hover:bg-green-800 text-white font-bold px-6 py-3.5 rounded-xl mt-6 transition shadow-lg shadow-green-700/20 disabled:opacity-50"
                >
                    {{ form.processing ? "Processing Payment..." : "Pay Now" }}
                </button>
            </div>
        </div>
    </MainLayout>
</template>
