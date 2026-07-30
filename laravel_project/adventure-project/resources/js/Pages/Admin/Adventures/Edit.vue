<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    adventure: Object,
    categories: Array,
});

const form = useForm({
    category_id: props.adventure.category_id || "",
    title: props.adventure.title || "",
    description: props.adventure.description || "",
    location: props.adventure.location || "",
    google_maps_url: props.adventure.google_maps_url || "",
    price: props.adventure.price || "",
    difficulty: props.adventure.difficulty || "",
    duration: props.adventure.duration || "",
    max_people: props.adventure.max_people || "",
    image: null,
    _method: "PUT",
});

const galleryFiles = ref([]);
const galleryPreviews = ref([]);

const handleGalleryImages = (e) => {
    const files = Array.from(e.target.files);
    galleryFiles.value = files;
    galleryPreviews.value = files.map((file) => URL.createObjectURL(file));
};

const submit = () => {
    if (galleryFiles.value.length) {
        form.images = galleryFiles.value;
    }

    form.post(route("admin.adventures.update", props.adventure.id), {
        onSuccess: () => {
            galleryFiles.value = [];
            galleryPreviews.value = [];
        },
    });
};

const deleteImage = (imageId) => {
    if (confirm("Are you sure you want to delete this image?")) {
        router.delete(
            route("admin.adventures.images.destroy", [props.adventure.id, imageId]),
            {
                preserveScroll: true,
            }
        );
    }
};

const setCover = (imageId) => {
    router.post(
        route("admin.adventures.images.cover", [props.adventure.id, imageId]),
        {},
        {
            preserveScroll: true,
        }
    );
};
</script>

<template>
    <AdminLayout>
        <div class="section">
            <div class="container">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="dashboard-title">Edit Adventure</h1>
                        <p class="dashboard-subtitle">Update package details, pricing, and destination media.</p>
                    </div>
                    <Link href="/admin/adventures" class="btn btn-secondary">
                        ← Back to List
                    </Link>
                </div>

                <form @submit.prevent="submit" class="card space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Adventure Title</label>
                            <input v-model="form.title" type="text" class="input-field" placeholder="e.g., Mount Kinabalu Trek" />
                            <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                            <select v-model="form.category_id" class="input-field">
                                <option value="" disabled>Select category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location</label>
                            <input v-model="form.location" type="text" class="input-field" placeholder="Sabah, Malaysia" />
                            <div v-if="form.errors.location" class="text-red-500 text-xs mt-1">{{ form.errors.location }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Google Maps URL</label>
                            <input v-model="form.google_maps_url" type="url" class="input-field" placeholder="https://maps.google.com/..." />
                            <div v-if="form.errors.google_maps_url" class="text-red-500 text-xs mt-1">{{ form.errors.google_maps_url }}</div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Price (RM)</label>
                            <input v-model="form.price" type="number" step="0.01" class="input-field" placeholder="350" />
                            <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Duration (Days)</label>
                            <input v-model="form.duration" type="number" class="input-field" placeholder="3" />
                            <div v-if="form.errors.duration" class="text-red-500 text-xs mt-1">{{ form.errors.duration }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Max People</label>
                            <input v-model="form.max_people" type="number" class="input-field" placeholder="10" />
                            <div v-if="form.errors.max_people" class="text-red-500 text-xs mt-1">{{ form.errors.max_people }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Difficulty Level</label>
                            <select v-model="form.difficulty" class="input-field">
                                <option value="" disabled>Select difficulty</option>
                                <option value="Easy">Easy</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Hard">Hard</option>
                                <option value="Extreme">Extreme</option>
                            </select>
                            <div v-if="form.errors.difficulty" class="text-red-500 text-xs mt-1">{{ form.errors.difficulty }}</div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                        <textarea v-model="form.description" rows="4" class="input-field" placeholder="Write a captivating summary of the adventure..."></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                    </div>

                    <div class="divider"></div>

                    <h3 class="text-lg font-bold text-gray-800">Adventure Photo</h3>
                    <div v-if="adventure.image" class="mb-4">
                        <img :src="'/storage/' + adventure.image" class="w-32 h-32 object-cover rounded-2xl shadow-md border border-gray-200" />
                        <span class="inline-block mt-2 text-xs font-bold px-2 py-1 bg-gray-900 text-white rounded-md">Current</span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Replace Photo</label>
                        <input type="file" @input="form.image = $event.target.files[0]" class="w-full p-2 border rounded" accept="image/*" />
                        <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <Link href="/admin/adventures" class="btn btn-secondary">Cancel</Link>
                        <button type="submit" :disabled="form.processing" class="btn btn-primary">
                            {{ form.processing ? "Saving..." : "Save Updates" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
