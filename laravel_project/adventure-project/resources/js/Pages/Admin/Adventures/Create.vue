<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    category_id: "",
    title: "",
    description: "",
    location: "",
    google_maps_url: "",
    price: "",
    difficulty: "",
    duration: "",
    max_people: "",
    image: null,
    images: [],
});

const galleryPreviews = ref([]);

const handleGalleryImages = (e) => {
    const files = Array.from(e.target.files);
    form.images = files;
    galleryPreviews.value = files.map((file) => URL.createObjectURL(file));
};

const submit = () => {
    form.post("/admin/adventures", {
        onSuccess: () => {
            galleryPreviews.value = [];
        },
    });
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
                <!-- 2. MAIN IMAGE UPLOAD SECTION -->
                <div class="mt-2">
                    <label class="block font-semibold">Upload Main Image</label>
                    <input
                        type="file"
                        @input="form.image = $event.target.files[0]"
                        class="w-full p-2 border rounded"
                    />
                    <div v-if="form.errors.image" class="text-sm text-red-500">
                        {{ form.errors.image }}
                    </div>
                </div>

                <!-- 3. GALLERY IMAGES UPLOAD SECTION -->
                <div class="mt-4">
                    <label class="block font-semibold">Adventure Images</label>
                    <input
                        type="file"
                        multiple
                        accept="image/*"
                        @change="handleGalleryImages"
                        class="w-full p-2 border rounded"
                    />
                    <div v-if="form.errors.images" class="text-sm text-red-500">
                        {{ form.errors.images }}
                    </div>

                    <!-- Image Previews -->
                    <div v-if="galleryPreviews.length" class="grid grid-cols-4 gap-3 mt-3">
                        <div
                            v-for="(preview, index) in galleryPreviews"
                            :key="index"
                            class="relative rounded-xl overflow-hidden border border-stone-200 h-24"
                        >
                            <img
                                :src="preview"
                                class="w-full h-full object-cover"
                            />
                        </div>
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

                <input
                    v-model="form.google_maps_url"
                    :class="inputClass"
                    placeholder="Google Maps URL"
                />

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
                    class="w-full px-5 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl disabled:opacity-50 transition shadow-sm"
                >
                    {{ form.processing ? "Saving..." : "Save Adventure" }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
