<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const search = ref('')
const location = ref('')
const category = ref('')
const price = ref('')

const locations = ['All Locations', 'Sabah', 'Sarawak', 'Kuala Lumpur', 'Langkawi', 'Penang', 'Johor', 'Ipoh', 'Cameron Highlands', 'Borneo']
const categories = ['All Categories', 'Hiking', 'Camping', 'Kayaking', 'Climbing', 'Wildlife', 'Cultural']
const prices = ['Any Price', 'Under RM100', 'RM100 - RM300', 'RM300 - RM500', 'Above RM500']

function handleSearch() {
    const params = {}
    if (search.value) params.search = search.value
    if (location.value && location.value !== 'All Locations') params.location = location.value
    if (category.value && category.value !== 'All Categories') params.category = category.value
    if (price.value && price.value !== 'Any Price') params.price = price.value

    router.get('/adventures', params, {
        preserveState: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="hero-search-overlay">
        <div class="hero-search-box">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search adventures, destinations..."
                        class="w-full pl-9 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 outline-none"
                    />
                </div>
                <button
                    @click="handleSearch"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-bold shadow-md transition whitespace-nowrap"
                >
                    Search
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">📍</span>
                    <select v-model="location" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 outline-none appearance-none cursor-pointer">
                        <option v-for="loc in locations" :key="loc" :value="loc">{{ loc }}</option>
                    </select>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">📁</span>
                    <select v-model="category" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 outline-none appearance-none cursor-pointer">
                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                    </select>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">💰</span>
                    <select v-model="price" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 outline-none appearance-none cursor-pointer">
                        <option v-for="p in prices" :key="p" :value="p">{{ p }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero-search-overlay {
    position: absolute;
    bottom: -60px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
    width: 90%;
    max-width: 800px;
}

.hero-search-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1);
}

.dark .hero-search-box {
    background: rgba(31, 41, 55, 0.95);
}

@media (max-width: 768px) {
    .hero-search-overlay {
        bottom: -40px;
        width: 95%;
    }

    .hero-search-box {
        padding: 1rem;
    }
}
</style>