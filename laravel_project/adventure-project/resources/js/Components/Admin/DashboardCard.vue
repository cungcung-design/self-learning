<script setup>
defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    color: String
})
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-6 border-l-4" :class="color">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                    {{ title }}
                </p>
                <h2 class="text-3xl font-bold mt-2 text-gray-800">
                    {{ value }}
                </h2>
            </div>
            <div class="text-4xl p-3 bg-gray-50 rounded-xl">
                {{ icon }}
            </div>
        </div>
    </div>
</template>