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
        class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex flex-col h-full"
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
                class="absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md transition-transform duration-200 hover:scale-110 active:scale-95"
                aria-label="Add to favorites"
            >
                🤍
            </button>
        </div>

        <!-- Content -->
        <div class="p-5 flex flex-col flex-grow">

            <!-- Category -->
            <span
                class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-2 self-start"
            >
                {{ adventure.category.name }}
            </span>

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 mb-4 line-clamp-1">
                {{ adventure.title }}
            </h2>

            <!-- Meta Details -->
            <div class="space-y-2 text-sm text-gray-500 mb-6">
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
            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                <div>
                    <span class="text-xs text-gray-400 block">Price</span>
                    <p class="text-2xl font-bold text-green-600">
                        RM {{ adventure.price }}
                    </p>
                </div>

                <Link :href="route('adventures.show', adventure.id)">
                    <PrimaryButton>
                        View Details
                    </PrimaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>
