<script setup>
defineProps({
    adventure: Object,
})
</script>

<template>
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-4">
        <h3 class="text-lg font-bold text-slate-900">Location</h3>
        <p class="text-sm text-gray-500">📍 {{ adventure.location }}</p>
        
        <div class="w-full h-72 rounded-2xl bg-stone-100 border border-stone-200 flex items-center justify-center text-gray-400 font-medium">
            🗺 Google Map Integration Placeholder
        </div>
    </div>
</template>