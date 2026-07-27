<script setup>
import AdventureCard from '@/Pages/User/AdventureCard.vue'

defineProps({
    adventures: Array,
})
</script>

<template>
    <section v-if="adventures && adventures.length > 0">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">
            You May Also Like
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <AdventureCard
                v-for="adventure in adventures"
                :key="adventure.id"
                :adventure="adventure"
            />
        </div>
    </section>
</template>