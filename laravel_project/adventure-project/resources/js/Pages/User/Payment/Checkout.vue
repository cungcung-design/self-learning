<script setup>
import { useForm } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'

const props = defineProps({
    booking: Object,
    payment: Object,
})

const form = useForm({
    payment_id: props.payment?.id ?? null,
})

const payNow = () => {
    form.post(route('user.payment.process', props.booking.id), {
        preserveScroll: true,
    })
}
</script>

<template>
    <MainLayout>
        <div class="max-w-4xl mx-auto py-12 px-6">
            <!-- Page Title -->
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-8">
                Checkout
            </h1>

            <div class="grid md:grid-cols-2 gap-8 items-start">
                
                <!-- Booking Summary Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-4">
                    <div class="overflow-hidden rounded-2xl bg-stone-100">
                        <img
                            :src="booking.adventure.image.startsWith('http') ? booking.adventure.image : `/storage/${booking.adventure.image}`"
                            :alt="booking.adventure.title"
                            class="h-52 w-full object-cover"
                        />
                    </div>

                    <h2 class="text-xl font-bold text-slate-900">
                        {{ booking.adventure.title }}
                    </h2>

                    <div class="space-y-2 text-sm text-gray-600 pt-2 border-t border-stone-100 font-medium">
                        <div class="flex items-center gap-2">
                            <span>📅</span>
                            <span>{{ booking.booking_date }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>👥</span>
                            <span>{{ booking.participants }} People</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-6">
                    <h2 class="text-xl font-bold text-slate-900">
                        Payment Summary
                    </h2>

                    <div class="flex items-center justify-between pt-4 border-t border-stone-100">
                        <span class="font-medium text-gray-500">Total</span>
                        <span class="text-3xl font-extrabold text-green-600">
                            RM {{ booking.total_price ?? (booking.participants * booking.adventure.price) }}
                        </span>
                    </div>

                    <PrimaryButton
                        @click="payNow"
                        :disabled="form.processing"
                        class="w-full py-3.5 text-base shadow-lg shadow-green-700/20"
                    >
                        {{ form.processing ? "Processing Payment..." : "Confirm Payment" }}
                    </PrimaryButton>
                </div>

            </div>
        </div>
    </MainLayout>
</template>