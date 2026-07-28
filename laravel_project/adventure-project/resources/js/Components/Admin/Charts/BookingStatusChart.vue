<script setup>
import { Pie } from "vue-chartjs";
import { Chart, ArcElement, Tooltip, Legend } from "chart.js";

Chart.register(ArcElement, Tooltip, Legend);

const props = defineProps({
    stats: Object
});

const data = {
    labels: ['Confirmed', 'Pending', 'Cancelled'],
    datasets: [
        {
            data: [
                props.stats.confirmed || 0,
                props.stats.pending || 0,
                props.stats.cancelled || 0
            ],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }
    ]
};
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Booking Status</h2>
        <div class="w-full max-w-xs mx-auto my-auto">
            <Pie :data="data" />
        </div>
    </div>
</template>