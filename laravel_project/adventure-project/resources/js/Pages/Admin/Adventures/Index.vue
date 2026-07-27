<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
    adventures: Array,
});

const deleteForm = useForm({});

function deleteAdventure(id) {
    if (confirm("Are you sure you want to delete this adventure?")) {
        deleteForm.delete(route('adventures.destroy', id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-5xl py-12 px-6 mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Adventure List
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Manage, edit, or delete existing adventures.
                    </p>
                </div>
                <Link
                    :href="route('adventures.create')"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-3 rounded-xl shadow-md transition duration-200 text-sm flex items-center gap-2"
                >
                    <span>+</span> Create New Adventure
                </Link>
            </div>

            <!-- List Grid -->
            <div v-if="adventures && adventures.length > 0" class="space-y-4">
                <div
                    v-for="adventure in adventures"
                    :key="adventure.id"
                    class="bg-white rounded-2xl p-5 shadow-sm border border-stone-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-all hover:shadow-md"
                >
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <!-- Image -->
                        <img
                            v-if="adventure.image"
                            :src="adventure.image.startsWith('http') ? adventure.image : `/storage/${adventure.image}`"
                            :alt="adventure.title"
                            class="object-cover w-20 h-20 rounded-xl bg-stone-100 flex-shrink-0"
                        />
                        <div v-else class="w-20 h-20 rounded-xl bg-stone-100 flex items-center justify-center text-gray-400 text-xs font-medium flex-shrink-0">
                            No Image
                        </div>

                        <!-- Info -->
                        <div>
                            <span
                                v-if="adventure.category?.name"
                                class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-1"
                            >
                                {{ adventure.category.name }}
                            </span>
                            <h2 class="text-lg font-bold text-slate-900 line-clamp-1">
                                {{ adventure.title }}
                            </h2>
                            <p class="font-extrabold text-green-600 mt-0.5">
                                RM {{ adventure.price }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end pt-3 sm:pt-0 border-t sm:border-0 border-stone-100">
                        <Link
                            :href="route('adventures.edit', adventure.id)"
                            class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white transition bg-blue-600 rounded-xl hover:bg-blue-700 shadow-sm"
                        >
                            Edit
                        </Link>
                        <button
                            @click="deleteAdventure(adventure.id)"
                            :disabled="deleteForm.processing"
                            class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white transition bg-red-600 rounded-xl hover:bg-red-700 shadow-sm disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-20 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
            >
                <div class="mx-auto w-16 h-16 bg-green-50 text-green-600 flex items-center justify-center rounded-2xl mb-4 shadow-sm text-2xl">
                    📂
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">
                    No adventures found
                </h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                    Get started by creating your first adventure package.
                </p>
                <Link
                    :href="route('adventures.create')"
                    class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition duration-200 text-sm"
                >
                    Create New Adventure
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>