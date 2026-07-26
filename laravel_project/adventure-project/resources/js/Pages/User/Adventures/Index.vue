<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdventureCard from "@/Pages/User/AdventureCard.vue";
import Pagination from "@/Components/UI/Pagination.vue";

const props = defineProps({
    adventures: Object,
    categories: Array,
    filters: Object,
});

const form = useForm({
    search: props.filters?.search ?? "",
    category: props.filters?.category ?? "",
    min_price: props.filters?.min_price ?? "",
    max_price: props.filters?.max_price ?? "",
    duration: props.filters?.duration ?? "",
    sort: props.filters?.sort ?? "latest",
});

function filter() {
    form.get(route("adventures.index"), {
        preserveState: true,
        preserveScroll: true,
    });
}
</script>

<template>
    <MainLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- Page Title -->
            <div class="mb-8">
                <h1
                    class="text-4xl font-extrabold text-slate-900 tracking-tight"
                >
                    All Adventures
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Discover, filter, and book your next unforgettable
                    experience.
                </p>
            </div>

            <!-- Filter & Search Toolbar -->
            <form
                @submit.prevent="filter"
                class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 mb-10 space-y-4"
            >
                <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1"
                            >Search</label
                        >
                        <input
                            v-model="form.search"
                            type="text"
                            placeholder="Search adventure..."
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        />
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1"
                            >Category</label
                        >
                        <select
                            v-model="form.category"
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
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

                    <!-- Min Price -->
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1"
                            >Min Price (RM)</label
                        >
                        <input
                            v-model="form.min_price"
                            type="number"
                            placeholder="Min Price"
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        />
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1"
                            >Max Price (RM)</label
                        >
                        <input
                            v-model="form.max_price"
                            type="number"
                            placeholder="Max Price"
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        />
                    </div>

                    <!-- Duration -->
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1"
                            >Duration</label
                        >
                        <input
                            v-model="form.duration"
                            type="number"
                            placeholder="Days"
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        />
                    </div>
                </div>

                <!-- Bottom Toolbar Row (Sort & Action Button) -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-stone-100"
                >
                    <div class="w-full sm:w-72">
                        <select
                            v-model="form.sort"
                            class="w-full border-stone-200 rounded-xl p-3 text-sm focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        >
                            <option value="latest">Sort by: Newest</option>
                            <option value="price_asc">Price: Low → High</option>
                            <option value="price_desc">
                                Price: High → Low
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="w-full sm:w-auto bg-green-700 hover:bg-green-800 text-white font-semibold px-8 py-3 rounded-xl shadow-md transition duration-200 text-sm"
                    >
                        Apply Filters
                    </button>
                </div>
            </form>

            <!-- Adventures Grid (Using pagination data stream: adventures.data) -->
            <div v-if="adventures.data && adventures.data.length > 0">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <AdventureCard
                        v-for="adventure in adventures.data"
                        :key="adventure.id"
                        :adventure="adventure"
                    />
                </div>

                <!-- Pagination Component -->
                <Pagination :links="adventures.links" />
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-20 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
            >
                <div
                    class="mx-auto w-16 h-16 bg-green-50 text-green-600 flex items-center justify-center rounded-2xl mb-4 shadow-sm text-2xl"
                >
                    🔍
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">
                    No adventures found
                </h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto">
                    Try adjusting your filters or search terms to find what
                    you're looking for.
                </p>
            </div>
        </div>
    </MainLayout>
</template>
