<script setup>
defineProps({
    adventure: Object,
})
</script>

<template>
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-4">
        <h3 class="text-lg font-bold text-slate-900">📍 Location</h3>
        <p class="text-sm text-gray-500 font-medium">{{ adventure.location }}</p>
        
        <div v-if="adventure.google_maps_url" class="pt-2">
            <a 
                :href="adventure.google_maps_url" 
                target="_blank" 
                class="inline-flex items-center gap-2 px-5 py-3 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl font-semibold text-sm transition">
                🗺 View on Google Maps
            </a>
        </div>

        <div class="w-full h-72 rounded-2xl bg-stone-100 border border-stone-200 flex items-center justify-center text-gray-400 font-medium">
            🗺 Google Map Integration Placeholder
        </div>
    </div>
</template>