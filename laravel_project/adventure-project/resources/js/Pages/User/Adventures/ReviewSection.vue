<script setup>
defineProps({
    reviews: Array,
})
</script>

<template>
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-6">
        <h3 class="text-lg font-bold text-slate-900">Reviews</h3>

        <div v-if="reviews && reviews.length > 0" class="space-y-6">
            <div v-for="review in reviews" :key="review.id" class="border-b border-stone-100 pb-6 last:border-none last:pb-0">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center">
                            {{ review.user?.name ? review.user.name.charAt(0) : 'U' }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm">{{ review.user?.name ?? 'Anonymous' }}</h4>
                            <span class="text-xs text-gray-400">Verified Explorer</span>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-sm">
                        {'★'.repeat(review.rating ?? 5)}
                    </div>
                </div>
                <p class="text-gray-600 text-sm pl-13">
                    {{ review.comment }}
                </p>
            </div>
        </div>

        <div v-else class="space-y-6">
            <!-- Sample Review 1 -->
            <div class="border-b border-stone-100 pb-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center">J</div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm">John</h4>
                            <span class="text-xs text-gray-400">2 days ago</span>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-sm">★★★★★</div>
                </div>
                <p class="text-gray-600 text-sm">Amazing experience! The guide was extremely helpful and professional throughout the climb.</p>
            </div>

            <!-- Sample Review 2 -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center">M</div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm">Mary</h4>
                            <span class="text-xs text-gray-400">1 week ago</span>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-sm">★★★★★</div>
                </div>
                <p class="text-gray-600 text-sm">Beautiful scenery and well-organized logistics. Totally worth every ringgit!</p>
            </div>
        </div>
    </div>
</template>