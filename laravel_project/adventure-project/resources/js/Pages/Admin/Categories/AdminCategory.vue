<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { PlusIcon, PencilSquareIcon, TrashIcon, TagIcon } from '@heroicons/vue/24/outline'

defineProps({ categories: Array })

const deleteCategory = (id) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('admin.categories.destroy', id))
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-5xl mx-auto px-6 py-12 md:py-16">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Categories</h1>
                    <p class="text-slate-500 text-sm mt-1">Manage adventure classification types.</p>
                </div>
                <Link 
                    :href="route('admin.categories.create')" 
                    class="inline-flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-green-700/25 transition text-sm"
                >
                    <PlusIcon class="w-5 h-5" /> Add Category
                </Link>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-5 font-bold w-20">ID</th>
                            <th class="p-5 font-bold">Category Name</th>
                            <th class="p-5 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <tr v-for="category in categories" :key="category.id" class="hover:bg-slate-50/50 transition">
                            <td class="p-5 font-bold text-slate-400">#{{ category.id }}</td>
                            <td class="p-5 font-bold text-slate-800 flex items-center gap-2">
                                <TagIcon class="w-4 h-4 text-green-600" /> {{ category.name }}
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <Link 
                                    :href="route('admin.categories.edit', category.id)" 
                                    class="inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3.5 py-1.5 rounded-xl transition text-xs"
                                >
                                    <PencilSquareIcon class="w-4 h-4" /> Edit
                                </Link>
                                <button 
                                    @click="deleteCategory(category.id)" 
                                    class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-3.5 py-1.5 rounded-xl transition text-xs"
                                >
                                    <TrashIcon class="w-4 h-4" /> Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="categories.length === 0">
                            <td colspan="3" class="p-12 text-center text-slate-400 font-semibold">
                                No categories found. Create your first one above!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AdminLayout>
</template>