<script setup>
import { Line } from "vue-chartjs";
import {
    Chart,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Filler
} from "chart.js";

Chart.register(
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Filler
);

const props = defineProps({
    labels: Array,
    values: Array
});

const data = {
    labels: props.labels,
    datasets: [
        {
            label: "Revenue (RM)",
            data: props.values,
            borderColor: "#3b82f6",
            backgroundColor: "rgba(59, 130, 246, 0.1)",
            fill: true,
            tension: 0.4
        }
    ]
};

const options = {
    responsive: true,
    plugins: {
        legend: { display: false }
    }
};
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Monthly Revenue</h2>
        <Line :data="data" :options="options" />
    </div>
</template>