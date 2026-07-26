<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import AdventureCard from "@/Pages/User/AdventureCard.vue";

defineProps({
    favorites: Array,
});
</script>

<template>
    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 px-6">
            <h1 class="text-4xl font-bold mb-8 text-slate-800">
                My Favorites ❤️
            </h1>

            <!-- Grid of Favorites -->
            <div v-if="favorites.length > 0" class="grid md:grid-cols-3 gap-6">
                <AdventureCard
                    v-for="favorite in favorites"
                    :key="favorite.id"
                    :adventure="favorite.adventure"
                />
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-16 bg-white rounded-2xl shadow-sm"
            >
                <p class="text-5xl mb-4">💔</p>
                <p class="text-gray-500 text-lg">
                    You haven't added any favorite adventures yet.
                </p>
            </div>
        </div>
    </MainLayout>
</template>
