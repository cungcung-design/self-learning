<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({ reviews: Array })
</script>

<template>
    <AdminLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl font-extrabold mb-10">Reviews</h1>
            <div v-if="reviews.length === 0" class="text-slate-500">No reviews yet.</div>
            <div v-else class="space-y-4">
                <div v-for="review in reviews" :key="review.id" class="bg-white p-6 rounded-3xl shadow-xl">
                    <p class="font-bold">{{ review.user?.name }}</p>
                    <p class="text-sm text-slate-600">{{ review.adventure?.title }}</p>
                    <p class="text-yellow-500">{{ '⭐'.repeat(review.rating) }}</p>
                    <p class="text-slate-700">{{ review.comment }}</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>