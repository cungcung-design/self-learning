<script setup>
defineProps({
    reviews: Array
})
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Latest Reviews</h3>
        <div class="space-y-4 divide-y divide-gray-100">
            <div v-for="review in reviews" :key="review.id" class="pt-4 first:pt-0">
                <div class="flex items-center space-x-1 text-yellow-400 text-sm mb-1">
                    <span v-for="star in review.rating" :key="star">⭐</span>
                </div>
                <p class="text-gray-800 font-medium text-sm">"{{ review.comment }}"</p>
                <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                    <span>{{ review.user?.name }}</span>
                    <span class="italic">{{ review.adventure?.title }}</span>
                </div>
            </div>
        </div>
    </div>
</template>