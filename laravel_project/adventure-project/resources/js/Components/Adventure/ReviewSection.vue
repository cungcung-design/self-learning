<script setup>
defineProps({
    reviews: Array,
})
</script>

<template>
    <section class="mt-12 space-y-6">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
            Reviews ⭐
        </h2>

        <div v-if="reviews && reviews.length > 0" class="space-y-4">
            <div
                v-for="review in reviews"
                :key="review.id"
                class="bg-white rounded-3xl shadow-sm border border-stone-100 p-6 space-y-3"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center text-sm">
                            {{ review.user?.name ? review.user.name.charAt(0) : 'U' }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">
                                {{ review.user?.name ?? 'Anonymous' }}
                            </h4>
                            <span class="text-xs text-gray-400">Verified Explorer</span>
                        </div>
                    </div>

                    <div class="text-yellow-400 text-sm font-bold">
                        {{ '★'.repeat(review.rating ?? 5) }}
                    </div>
                </div>

                <p class="text-gray-600 text-sm leading-relaxed pl-13">
                    {{ review.comment }}
                </p>
            </div>
        </div>

        <div
            v-else
            class="text-center py-12 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
        >
            <p class="text-gray-500 font-medium text-sm">
                No reviews yet. Be the first to share your experience!
            </p>
        </div>
    </section>
</template>