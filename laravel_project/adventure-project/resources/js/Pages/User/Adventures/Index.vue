 <script setup>
import { useForm } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import AdventureCard from '@/Pages/User/AdventureCard.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'

const props = defineProps({
    adventures: Object,
    categories: Array,
    filters: Object,
})

const form = useForm({
    search: props.filters?.search ?? '',
    category: props.filters?.category ?? '',
    min_price: props.filters?.min_price ?? '',
    max_price: props.filters?.max_price ?? '',
    duration: props.filters?.duration ?? '',
    sort: props.filters?.sort ?? '',
})

function filter() {
    form.get(route('adventures.index'), {
        preserveState: true,
        preserveScroll: true,
    })
}

function reset() {
    form.search = ''
    form.category = ''
    form.min_price = ''
    form.max_price = ''
    form.duration = ''
    form.sort = ''

    filter()
}
</script>

<template>
    <MainLayout>
        <!-- Hero Header with Search Overlay -->
        <section class="relative bg-gradient-to-r from-green-800 to-green-600 text-white pt-32 pb-12 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative max-w-7xl mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                    Explore Adventures
                </h1>
                <p class="text-base md:text-lg text-green-100 max-w-xl mx-auto">
                    Discover breathtaking destinations and experience unforgettable moments.
                </p>
            </div>

            <!-- Search & Filter Overlay -->
            <div class="absolute bottom-0 left-0 w-full flex justify-center pb-6">
                <form
                    @submit.prevent="filter"
                    class="bg-white text-gray-800 w-full max-w-5xl mx-4 md:mx-0 rounded-2xl shadow-xl border border-stone-100 p-4 md:p-6 space-y-4"
                >
                <!-- Search Input Row -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                        🔍 Search
                    </label>
                    <input
                        v-model="form.search"
                        type="text"
                        placeholder="Search adventure..."
                        class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                    />
                </div>

                <!-- Filters Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                            Category
                        </label>
                        <select
                            v-model="form.category"
                            class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm bg-white"
                        >
                            <option value="">All Categories</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Duration Filter -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                            Duration
                        </label>
                        <select
                            v-model="form.duration"
                            class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm bg-white"
                        >
                            <option value="">All Durations</option>
                            <option value="1">1 Day</option>
                            <option value="2">2 Days</option>
                            <option value="3">3 Days</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                            Price Range (RM)
                        </label>
                        <div class="flex items-center gap-2">
                            <input
                                v-model="form.min_price"
                                type="number"
                                placeholder="Min"
                                class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                            />
                            <input
                                v-model="form.max_price"
                                type="number"
                                placeholder="Max"
                                class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                            />
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                            Sort By
                        </label>
                        <select
                            v-model="form.sort"
                            class="w-full border-stone-200 rounded-2xl p-3.5 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm bg-white"
                        >
                            <option value="">Newest</option>
                            <option value="price_low">Price: Low → High</option>
                            <option value="price_high">Price: High → Low</option>
                            <option value="name">Name (A–Z)</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-stone-100">
                    <button
                        type="button"
                        @click="reset"
                        class="px-6 py-3 rounded-xl border border-stone-200 hover:bg-stone-50 text-gray-700 font-semibold text-sm transition duration-200"
                    >
                        Reset
                    </button>

                    <PrimaryButton type="submit" class="px-8">
                        Search
                    </PrimaryButton>
                </div>
            </form>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-6 pb-20 -mt-8">
            <!-- Results Count -->
            <div v-if="adventures.total !== undefined" class="mb-6">
                <p class="text-sm font-medium text-gray-500">
                    Showing <span class="text-slate-900 font-bold">{{ adventures.total }}</span> Adventures
                </p>
            </div>

            <!-- Adventures Grid -->
            <div v-if="adventures.data && adventures.data.length > 0">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <AdventureCard
                        v-for="adventure in adventures.data"
                        :key="adventure.id"
                        :adventure="adventure"
                    />
                </div>

                <!-- Pagination Component -->
                <div class="flex justify-center">
                    <Pagination :links="adventures.links" />
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-20 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
            >
                <div class="mx-auto w-16 h-16 bg-green-50 text-green-600 flex items-center justify-center rounded-2xl mb-4 shadow-sm text-2xl">
                    🔍
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">
                    No adventures found
                </h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto">
                    Try adjusting your filters or search terms to find what you're looking for.
                </p>
            </div>
        </div>
    </MainLayout>
</template>

