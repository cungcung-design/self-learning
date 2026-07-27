<script setup>
import { ref, computed } from 'vue'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'

const props = defineProps({
    adventure: Object,
})

const participants = ref(2)

const totalPrice = computed(() => {
    return props.adventure.price * participants.value
})

function decrement() {
    if (participants.value > 1) participants.value--
}

function increment() {
    if (participants.value < props.adventure.max_people) participants.value++
}

function bookNow() {
    // Handle booking action logic here
}
</script>

<template>
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-lg border border-stone-100 space-y-6">
        <!-- Price & Favorite Header -->
        <div class="flex items-center justify-between border-b border-stone-100 pb-6">
            <div>
                <span class="text-2xl md:text-3xl font-extrabold text-green-600">RM {{ adventure.price }}</span>
                <span class="text-sm text-gray-400 ml-1">/ person</span>
            </div>
            <button
                class="p-2.5 bg-stone-50 rounded-full shadow-sm hover:bg-stone-100 transition active:scale-95"
                aria-label="Favorite"
            >
                ❤️
            </button>
        </div>

        <!-- Choose Date -->
        <div class="space-y-2">
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Choose Date</label>
            <div class="border border-stone-200 rounded-2xl p-3.5 text-sm text-gray-600 bg-stone-50 flex items-center justify-between cursor-pointer hover:border-green-600 transition">
                <span>📅 Select tour date</span>
                <span class="text-xs font-bold text-green-600">Change</span>
            </div>
        </div>

        <!-- Participants Counter -->
        <div class="space-y-2">
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Participants</label>
            <div class="flex items-center justify-between border border-stone-200 rounded-2xl p-3 bg-white">
                <button
                    type="button"
                    @click="decrement"
                    class="w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-800 font-bold flex items-center justify-center transition disabled:opacity-40"
                    :disabled="participants <= 1"
                >
                    -
                </button>
                <span class="font-bold text-slate-900 text-lg">{{ participants }}</span>
                <button
                    type="button"
                    @click="increment"
                    class="w-10 h-10 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-800 font-bold flex items-center justify-center transition disabled:opacity-40"
                    :disabled="participants >= adventure.max_people"
                >
                    +
                </button>
            </div>
        </div>

        <!-- Total Calculation -->
        <div class="border-t border-stone-100 pt-6 flex items-center justify-between">
            <span class="font-semibold text-gray-600">Total</span>
            <span class="text-2xl font-extrabold text-slate-900">RM {{ totalPrice }}</span>
        </div>

        <!-- Book Action Button -->
        <PrimaryButton @click="bookNow" class="w-full py-4 text-base">
            Book Now
        </PrimaryButton>
    </div>
</template>