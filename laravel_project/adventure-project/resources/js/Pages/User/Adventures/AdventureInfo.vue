<script setup>
defineProps({
    adventure: Object,
})

const inclusions = [
    'Professional Guide',
    'Meals',
    'Transportation',
    'Safety Equipment',
    'Insurance',
    'Accommodation',
]
</script>

<template>
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-6">
        <!-- Header Info -->
        <div>
            <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                🏔 {{ adventure.category?.name || 'Adventure' }}
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">
                {{ adventure.title }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <span class="flex items-center gap-1 font-semibold text-slate-800">
                    ⭐ {{ adventure.rating ?? '4.9' }} <span class="font-normal text-gray-400">({{ adventure.reviews?.length ?? 124 }} Reviews)</span>
                </span>
                <span>📍 {{ adventure.location }}</span>
                <span>🕒 {{ adventure.duration }}</span>
                <span>👥 Max {{ adventure.max_people }} People</span>
            </div>
        </div>

        <!-- Description -->
        <div class="border-t border-stone-100 pt-6">
            <h3 class="text-lg font-bold text-slate-900 mb-3">Description</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ adventure.description || 'Experience the thrill of a lifetime with our guided expedition. Designed for outdoor enthusiasts looking for breathtaking views, professional safety support, and unforgettable memories.' }}
            </p>
        </div>

        <!-- What's Included -->
        <div class="border-t border-stone-100 pt-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">What's Included</h3>
            <div class="grid sm:grid-cols-2 gap-3">
                <div v-for="item in inclusions" :key="item" class="flex items-center gap-2 text-sm text-gray-700 font-medium">
                    <span class="w-6 h-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xs">✓</span>
                    <span>{{ item }}</span>
                </div>
            </div>
        </div>
    </div>
</template>