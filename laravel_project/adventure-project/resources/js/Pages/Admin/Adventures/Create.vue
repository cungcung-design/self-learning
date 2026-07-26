<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    category_id: "",
    title: "",
    description: "",
    location: "",
    price: "",
    difficulty: "",
    duration: "",
    max_people: "",
    image: null,
});

const submit = () => {
    form.post("/adventures");
};

// Reusable styling classes
const inputClass = "border p-2 rounded w-full mb-2";
</script>

<template>
    <AdminLayout>
        <div class="max-w-xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
            <h1 class="mb-6 text-3xl font-bold">Create Adventure</h1>

            <form @submit.prevent="submit" class="flex flex-col gap-3">
                <!-- Category Selection -->
                <select v-model="form.category_id" :class="inputClass">
                    <option value="">Select Category</option>
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.name }}
                    </option>
                </select>
                <div
                    v-if="form.errors.category_id"
                    class="text-sm text-red-500"
                >
                    {{ form.errors.category_id }}
                </div>
                <!-- 2. IMAGE UPLOAD SECTION -->
                <div class="mt-2">
                    <label class="block font-semibold">Upload Image</label>
                    <input
                        type="file"
                        @input="form.image = $event.target.files[0]"
                        class="w-full p-2 border rounded"
                    />
                    <div v-if="form.errors.image" class="text-sm text-red-500">
                        {{ form.errors.image }}
                    </div>
                </div>

                <!-- Basic Info -->
                <input
                    v-model="form.title"
                    :class="inputClass"
                    placeholder="Adventure Title"
                />

                <textarea
                    v-model="form.description"
                    :class="inputClass"
                    placeholder="Description"
                ></textarea>

                <div class="grid grid-cols-2 gap-2">
                    <input
                        v-model="form.location"
                        :class="inputClass"
                        placeholder="Location"
                    />
                    <input
                        v-model="form.price"
                        type="number"
                        :class="inputClass"
                        placeholder="Price"
                    />
                </div>

                <!-- Details -->
                <select v-model="form.difficulty" :class="inputClass">
                    <option value="" disabled>Select Difficulty</option>
                    <option>Easy</option>
                    <option>Medium</option>
                    <option>Hard</option>
                </select>

                <div class="grid grid-cols-2 gap-2">
                    <input
                        v-model="form.duration"
                        :class="inputClass"
                        placeholder="Duration (e.g., 2 hours)"
                    />
                    <input
                        v-model="form.max_people"
                        type="number"
                        :class="inputClass"
                        placeholder="Max People"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="p-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 disabled:opacity-50"
                >
                    {{ form.processing ? "Saving..." : "Save Adventure" }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
