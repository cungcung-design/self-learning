<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'
import SeatBadge from '@/Components/Calendar/SeatBadge.vue'

const props = defineProps({
    adventure: Object,
})

const participants = ref(2)
const selectedScheduleId = ref(null)

const totalPrice = computed(() => {
    return props.adventure.price * participants.value
})

const availableSchedules = computed(() => {
    if (!props.adventure.schedules) return []
    return props.adventure.schedules.filter(
        (s) => s.status === 'available' && s.capacity - s.booked > 0
    )
})

const selectedSchedule = computed(() => {
    return availableSchedules.value.find((s) => s.id === selectedScheduleId.value) || null
})

function decrement() {
    if (participants.value > 1) participants.value--
}

function increment() {
    if (participants.value < props.adventure.max_people) participants.value++
}

const form = useForm({
    schedule_id: null,
    participants: 2,
})

function bookNow() {
    if (!selectedScheduleId.value) {
        alert('Please select a trip date.')
        return
    }

    form.schedule_id = selectedScheduleId.value
    form.participants = participants.value

    form.post(`/adventures/${props.adventure.id}/book`, {
        preserveScroll: true,
        onSuccess: () => {
            selectedScheduleId.value = null
            participants.value = 2
        },
    })
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

        <!-- Choose Trip Date -->
        <div class="space-y-2">
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Choose Trip Date</label>
            <div class="space-y-2">
                <div
                    v-for="schedule in availableSchedules"
                    :key="schedule.id"
                    @click="schedule.status === 'available' && (selectedScheduleId = schedule.id)"
                    class="border rounded-2xl p-3 flex justify-between items-center cursor-pointer transition"
                    :class="{
                        'border-blue-600 bg-blue-50/30': selectedScheduleId === schedule.id,
                        'opacity-50 cursor-not-allowed bg-gray-50': schedule.status !== 'available',
                    }"
                >
                    <div>
                        <div class="font-bold text-gray-800">📅 {{ schedule.trip_date }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">🕒 {{ schedule.start_time }} - {{ schedule.end_time }}</div>
                    </div>
                    <SeatBadge
                        :status="schedule.status"
                        :remaining="schedule.capacity - schedule.booked"
                    />
                </div>
            </div>
            <div v-if="availableSchedules.length === 0" class="text-xs text-gray-500">
                No available schedules for this adventure.
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
        <PrimaryButton @click="bookNow" :disabled="!selectedScheduleId || form.processing" class="w-full py-4 text-base">
            {{ form.processing ? 'Processing...' : 'Confirm & Proceed to Checkout' }}
        </PrimaryButton>
    </div>
</template>
