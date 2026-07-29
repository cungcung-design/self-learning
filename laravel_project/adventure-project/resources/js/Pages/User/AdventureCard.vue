<script setup>
import { Link, router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'

const props = defineProps({
    adventure: {
        type: Object,
        required: true,
    },
})

function toggleFavorite(id) {
    router.post(route('user.favorites.store', id))
}
</script>

<template>
    <div
        class="bg-white dark:bg-gray-800 dark:text-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex flex-col h-full border border-gray-100 dark:border-gray-700"
    >
        <!-- Image & Favorite Action -->
        <div class="relative">
            <img
                :src="adventure.image ? '/storage/' + adventure.image : 'https://placehold.co/600x400?text=No+Image'"
                :alt="adventure.title"
                class="w-full h-56 object-cover"
            />

            <!-- Favorite Button (Top Right) -->
            <button
                @click="toggleFavorite(adventure.id)"
                class="absolute top-3 right-3 p-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full shadow-md transition-transform duration-200 hover:scale-110 active:scale-95"
                aria-label="Add to favorites"
            >
                🤍
            </button>
        </div>

        <!-- Content -->
        <div class="p-5 flex flex-col flex-grow">

            <!-- Category -->
            <span
                class="inline-block bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-semibold px-3 py-1 rounded-full mb-2 self-start"
            >
                {{ adventure.category.name }}
            </span>

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4 line-clamp-1">
                {{ adventure.title }}
            </h2>

            <!-- Meta Details -->
            <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
                <div class="flex items-center gap-2">
                    <span>📍</span>
                    <span class="truncate">{{ adventure.location }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>🕒</span>
                    <span>{{ adventure.duration }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>👥</span>
                    <span>Max {{ adventure.max_people }} People</span>
                </div>
            </div>

            <!-- Price & Action Footer (Inline layout) -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                <div>
                    <span class="text-xs text-gray-400 dark:text-gray-500 block">Price</span>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                        RM {{ adventure.price }}
                    </p>
                </div>

                <Link :href="route('adventures.show', adventure.id)" class="w-full sm:w-auto">
                    <span class="block w-full text-center px-5 py-3 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                        View Details
                    </span>
                </Link>
            </div>
        </div>
    </div>
</template>
