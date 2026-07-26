<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    adventureId: Number,
});

const emit = defineEmits(["update:bookingDate"]);

const dates = ref([]);
const selectedDate = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get(
            `/adventures/${props.adventureId}/availability`,
        );
        dates.value = response.data;
    } catch (error) {
        console.error("Error fetching availability:", error);
    }
});

function choose(date) {
    if (date.status !== "full") {
        selectedDate.value = date.date;
        emit("update:bookingDate", date.date);
    }
}
</script>

<template>
    <div class="mb-6">
        <h2 class="text-lg font-bold mb-3 text-slate-800">Choose Date</h2>

        <div class="grid grid-cols-3 gap-2 max-h-60 overflow-y-auto p-1">
            <button
                type="button"
                v-for="day in dates"
                :key="day.date"
                @click="choose(day)"
                :disabled="day.status === 'full'"
                class="p-3 rounded-xl border text-left transition text-xs"
                :class="{
                    'bg-green-50 border-green-200 hover:bg-green-100':
                        day.status === 'available',
                    'bg-yellow-50 border-yellow-200 hover:bg-yellow-100':
                        day.status === 'almost_full',
                    'bg-red-50 border-red-200 opacity-50 cursor-not-allowed':
                        day.status === 'full',
                    'ring-2 ring-green-600': selectedDate === day.date,
                }"
            >
                <p class="font-semibold text-slate-800">{{ day.date }}</p>
                <p class="text-[10px] text-gray-500 mt-1">
                    {{ day.remaining }} seats left
                </p>
            </button>
        </div>

        <p
            v-if="selectedDate"
            class="mt-3 text-green-700 font-semibold text-sm"
        >
            Selected Date: {{ selectedDate }}
        </p>
    </div>
</template>
