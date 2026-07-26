<script setup>
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    adventure: Object,
});

const toggleFavorite = () => {
    router.post(route("user.favorites.store"), {
        adventure_id: props.adventure.id,
    });
};
</script>

<template>
    <div
        class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col justify-between relative"
    >
        <!-- Favorite Heart Button (Moved inside the card, absolute top-right) -->
        <button
            @click="toggleFavorite"
            class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm rounded-full p-2.5 shadow-md hover:bg-white transition z-10 cursor-pointer"
        >
            {{ adventure.is_favorited ? "❤️" : "🤍" }}
        </button>

        <!-- Image Header -->
        <div class="h-56 overflow-hidden relative">
            <img
                v-if="adventure.image"
                :src="'/storage/' + adventure.image"
                :alt="adventure.title"
                class="w-full h-full object-cover hover:scale-105 transition duration-500"
            />
            <div
                v-else
                class="h-full bg-green-100 flex items-center justify-center text-5xl"
            >
                🏔️
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <!-- Category -->
                <span
                    class="text-sm text-green-700 font-semibold uppercase tracking-wider"
                >
                    {{ adventure.category?.name }}
                </span>

                <!-- Title -->
                <h3 class="text-xl font-bold text-slate-800 mt-2">
                    {{ adventure.title }}
                </h3>

                <!-- Location -->
                <p class="text-gray-500 mt-2 text-sm flex items-center gap-1">
                    📍 {{ adventure.location }}
                </p>

                <!-- Info Badges -->
                <div
                    class="flex justify-between mt-4 text-sm text-gray-600 bg-stone-50 p-3 rounded-xl"
                >
                    <span>🕒 {{ adventure.duration }} Days</span>
                    <span>👥 Max {{ adventure.max_people }}</span>
                </div>
            </div>

            <!-- Price and Action Footer -->
            <div
                class="flex justify-between items-center mt-6 pt-4 border-t border-stone-100"
            >
                <div>
                    <p class="text-xs text-gray-400">Starting from</p>
                    <p class="text-xl font-bold text-green-700">
                        RM {{ adventure.price }}
                    </p>
                </div>

                <Link
                    :href="route('adventures.show', adventure.id)"
                    class="bg-green-700 text-white px-5 py-2.5 rounded-xl hover:bg-green-800 transition shadow-sm font-medium text-sm"
                >
                    View
                </Link>
            </div>
        </div>
    </div>
</template>
