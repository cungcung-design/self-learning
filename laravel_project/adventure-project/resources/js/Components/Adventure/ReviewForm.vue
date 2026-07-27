<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    adventureId: {
        type: Number,
        required: true,
    },
})

const form = useForm({
    rating: 0,
    comment: '',
})

const submit = () => {
    form.post(route('user.reviews.store', props.adventureId), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
    })
}

function setRating(value) {
    form.rating = value
}
</script>

<template>
    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Leave a Review</h3>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Star Rating -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Rating</label>
                <div class="flex items-center gap-1">
                    <button
                        v-for="i in 5"
                        :key="i"
                        type="button"
                        @click="setRating(i)"
                        class="text-2xl transition-colors duration-150 hover:scale-110"
                        :class="i <= form.rating ? 'text-yellow-400' : 'text-gray-300'"
                    >
                        ★
                    </button>
                    <span v-if="form.rating > 0" class="ml-2 text-sm text-gray-500">
                        {{ form.rating }} / 5
                    </span>
                </div>
                <div v-if="form.errors.rating" class="text-rose-500 text-xs mt-1.5 font-medium">
                    {{ form.errors.rating }}
                </div>
            </div>

            <!-- Comment -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Comment</label>
                <textarea
                    v-model="form.comment"
                    rows="4"
                    placeholder="Share your experience..."
                    class="w-full border-stone-200 rounded-xl p-3 focus:ring-green-600 focus:border-green-600 text-sm shadow-sm transition resize-none"
                ></textarea>
                <div v-if="form.errors.comment" class="text-rose-500 text-xs mt-1.5 font-medium">
                    {{ form.errors.comment }}
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                :disabled="form.processing || form.rating === 0"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-700/20 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ form.processing ? 'Submitting...' : 'Submit Review' }}
            </button>
        </form>
    </div>
</template>

