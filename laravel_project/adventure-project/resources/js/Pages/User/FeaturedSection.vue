<script setup>
import AdventureCard from '@/Pages/User/AdventureCard.vue'

defineProps({
    adventures: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-extrabold text-center mb-12 text-slate-900 tracking-tight">
                Featured Adventures
            </h2>

            <!-- Grid Layout -->
            <div
                v-if="adventures && adventures.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            >
                <AdventureCard
                    v-for="adventure in adventures"
                    :key="adventure.id"
                    :adventure="adventure"
                />
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-12 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
            >
                <p class="text-gray-500 font-medium">
                    No featured adventures available right now.
                </p>
            </div>
        </div>
    </section>
</template>