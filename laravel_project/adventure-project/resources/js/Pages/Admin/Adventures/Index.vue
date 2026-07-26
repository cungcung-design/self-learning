<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
    adventures: Array,
});

const deleteForm = useForm({});

const deleteAdventure = (id) => {
    if (confirm("Are you sure you want to delete this adventure?")) {
        deleteForm.delete(route("adventures.destroy", id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-4xl py-10 mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Adventure List</h1>
                <Link
                    :href="route('adventures.create')"
                    class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700"
                >
                    Create New Adventure
                </Link>
            </div>

            <div class="grid gap-6">
                <div
                    v-for="adventure in adventures"
                    :key="adventure.id"
                    class="flex items-center gap-4 p-4 border rounded shadow-sm"
                >
                    <!-- Image -->
                    <img
                        v-if="adventure.image"
                        :src="'/storage/' + adventure.image"
                        class="object-cover w-24 h-24 rounded"
                    />
                    <!-- Info -->
                    <div class="flex-grow">
                        <h2 class="text-xl font-bold">
                            {{ adventure.title }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ adventure.category?.name }}
                        </p>
                        <p class="font-semibold text-blue-600">
                            $
                            {{ adventure.price }}
                        </p>
                    </div>
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <Link
                            :href="route('adventures.edit', adventure.id)"
                            class="px-4 py-2 text-white transition bg-blue-500 rounded hover:bg-blue-600"
                        >
                            Edit
                        </Link>
                        <button
                            @click="deleteAdventure(adventure.id)"
                            class="px-4 py-2 text-white transition bg-red-500 rounded hover:bg-red-600"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
