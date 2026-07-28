<script setup>
defineProps({
    adventures: Array
})
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Top Adventures</h3>

        <div v-if="adventures && adventures.length > 0" class="space-y-4">
            <div
                v-for="(adventure, index) in adventures"
                :key="adventure.id"
                class="flex justify-between items-center border-b border-gray-100 pb-3 last:border-0"
            >
                <div class="flex items-center gap-3">
                    <span class="text-base">
                        {{ index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : `${index + 1}.` }}
                    </span>
                    <span class="font-medium text-gray-700">
                        {{ adventure.title }}
                    </span>
                </div>

                <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full font-medium">
                    {{ adventure.bookings_count ?? 0 }} bookings
                </span>
            </div>
        </div>

        <div v-else class="text-sm text-gray-400 text-center py-4">
            No top adventures available yet.
        </div>
    </div>
</template>