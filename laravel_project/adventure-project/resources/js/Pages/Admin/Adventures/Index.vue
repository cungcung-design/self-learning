<script setup>
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    adventures: Object,
    categories: Array,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const category = ref(props.filters?.category || '');

const pickBy = (obj) => {
    return Object.fromEntries(Object.entries(obj).filter(([, v]) => v !== '' && v !== null && v !== undefined));
};

let throttleTimer = null;
watch([search, category], () => {
    if (throttleTimer) clearTimeout(throttleTimer);
    throttleTimer = setTimeout(() => {
        router.get('/admin/adventures', pickBy({ search: search.value, category: category.value }), {
            preserveState: true,
            replace: true,
        });
    }, 300);
});
</script>

<template>
    <AdminLayout>
        <div class="space-y-6">

            <!-- Header & Action Row -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">🏔 Manage Adventures</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create, edit, and organize all outdoor catalog listings.</p>
                </div>
                <Link href="/admin/adventures/create" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                    + Add New Adventure
                </Link>
            </div>

            <!-- Filters & Search Bar Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4 items-center justify-between">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search by title or location..."
                    class="w-full md:w-96 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 transition"
                />

                <select
                    v-model="category"
                    class="w-full md:w-64 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 transition"
                >
                    <option value="">All Categories</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <!-- Data Table Container -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                                <th class="py-4 px-6">ID</th>
                                <th class="py-4 px-6">Image</th>
                                <th class="py-4 px-6">Adventure Title</th>
                                <th class="py-4 px-6">Category</th>
                                <th class="py-4 px-6">Price</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                            <tr v-for="adventure in adventures.data" :key="adventure.id" class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition">
                                <td class="py-4 px-6 font-semibold text-gray-500 dark:text-gray-400">#{{ adventure.id }}</td>
                                <td class="py-4 px-6">
                                    <img :src="`/storage/${adventure.image}`" class="w-12 h-12 rounded-xl object-cover shadow-sm" />
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ adventure.title }}</div>
                                    <div class="text-xs text-gray-400">📍 {{ adventure.location }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ adventure.category?.name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-gray-900 dark:text-white">
                                    RM {{ adventure.price }}
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <Link :href="`/admin/adventures/${adventure.id}/edit`" class="inline-block p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-xs font-semibold transition" title="Edit">
                                        ✏️
                                    </Link>
                                    <form :action="`/admin/adventures/${adventure.id}`" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this adventure?');">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <input type="hidden" name="_token" :value="$page.props.csrf" />
                                        <button type="submit" class="inline-block p-2 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 text-red-600 rounded-xl text-xs font-semibold transition" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr v-if="!adventures.data.length">
                                <td colspan="6" class="text-center py-12 text-gray-400">No adventures found matching your criteria.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500">
                    <span>Showing {{ adventures.from ?? 0 }} to {{ adventures.to ?? 0 }} of {{ adventures.total }} adventures</span>

                    <div class="flex gap-1">
                        <template v-for="(link, index) in adventures.links" :key="index">
                            <component
                                :is="link.url ? Link : 'span'"
                                :href="link.url"
                                v-html="link.label"
                                class="px-3 py-1.5 rounded-lg border text-xs font-semibold transition"
                                :class="{
                                    'bg-green-600 text-white border-green-600': link.active,
                                    'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100': link.url && !link.active,
                                    'opacity-50 cursor-not-allowed bg-gray-100 dark:bg-gray-800 text-gray-400': !link.url
                                }"
                            />
                        </template>
                    </div>
                </div>

            </div>

        </div>
    </AdminLayout>
</template>
