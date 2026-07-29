<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import {
    ArrowLeftIcon,
    PhotoIcon,
    CloudArrowUpIcon,
} from "@heroicons/vue/24/outline";
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

    form.post(route("adventures.update", props.adventure.id), {
        onSuccess: () => {
            galleryFiles.value = [];
            galleryPreviews.value = [];
        },
    });
};

const deleteImage = (imageId) => {
    if (confirm("Are you sure you want to delete this image?")) {
        router.delete(
            route("adventures.images.destroy", [props.adventure.id, imageId]),
            {
                preserveScroll: true,
            }
        );
    }
};

const setCover = (imageId) => {
    router.post(
        route("adventures.images.cover", [props.adventure.id, imageId]),
        {},
        {
            preserveScroll: true,
        }
    );
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto px-6 py-12">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1
                        class="text-3xl font-extrabold text-slate-900 tracking-tight"
                    >
                        Edit Adventure
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Update package details, pricing, and destination media.
                    </p>
                </div>
                <Link
                    :href="route('adventures.index')"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-green-700 bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm transition"
                >
                    <ArrowLeftIcon class="w-4 h-4" /> Back to List
                </Link>
            </div>

            <!-- Main Form Card -->
            <div
                class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Title & Category Row -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Adventure Title</label
                            >
                            <input
                                type="text"
                                v-model="form.title"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                                placeholder="e.g., Mount Kinabalu Trek"
                            />
                            <div
                                v-if="form.errors.title"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Category</label
                            >
                            <select
                                v-model="form.category_id"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                            >
                                <option value="" disabled>
                                    Select category
                                </option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.category_id"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.category_id }}
                            </div>
                        </div>
                    </div>

                    <!-- Location, Price, Duration, Max People Grid -->
                    <div class="grid md:grid-cols-4 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Location</label
                            >
                            <input
                                type="text"
                                v-model="form.location"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                                placeholder="Sabah, Malaysia"
                            />
                            <div
                                v-if="form.errors.location"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.location }}
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Google Maps URL</label
                            >
                            <input
                                type="url"
                                v-model="form.google_maps_url"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                                placeholder="https://maps.google.com/..."
                            />
                            <div
                                v-if="form.errors.google_maps_url"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.google_maps_url }}
                            </div>
                        </div>
                    </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Price (RM)</label
                            >
                            <input
                                type="number"
                                step="0.01"
                                v-model="form.price"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                                placeholder="350"
                            />
                            <div
                                v-if="form.errors.price"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.price }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Duration (Days)</label
                            >
                            <input
                                type="number"
                                v-model="form.duration"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                                placeholder="3"
                            />
                            <div
                                v-if="form.errors.duration"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.duration }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                >Max People</label
                            >
                            <input
                                type="number"
                                v-model="form.max_people"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                                placeholder="10"
                            />
                            <div
                                v-if="form.errors.max_people"
                                class="text-red-500 text-xs mt-1.5 font-medium"
                            >
                                {{ form.errors.max_people }}
                            </div>
                        </div>
                    </div>

                    <!-- Difficulty Selection -->
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                            >Difficulty Level</label
                        >
                        <select
                            v-model="form.difficulty"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                        >
                            <option value="" disabled>Select difficulty</option>
                            <option value="Easy">Easy</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Hard">Hard</option>
                            <option value="Extreme">Extreme</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm"
                            placeholder="Write a captivating summary of the adventure..."
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="text-red-500 text-xs mt-1.5 font-medium"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Media Upload Section -->
                    <div class="pt-4 border-t border-slate-100">
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3"
                            >Adventure Photo</label
                        >

                        <div
                            class="flex flex-col sm:flex-row items-center gap-6"
                        >
                            <!-- Current Image Preview -->
                            <div v-if="adventure.image" class="relative group">
                                <img
                                    :src="'/storage/' + adventure.image"
                                    class="w-32 h-32 object-cover rounded-2xl shadow-md border border-slate-200"
                                />
                                <span
                                    class="absolute bottom-2 left-2 bg-slate-900/70 text-white text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-sm"
                                    >Current</span
                                >
                            </div>
                            <div
                                v-else
                                class="w-32 h-32 bg-slate-100 rounded-2xl border border-slate-200 flex flex-col items-center justify-center text-slate-400"
                            >
                                <PhotoIcon class="w-8 h-8 mb-1" />
                                <span class="text-xs">No image</span>
                            </div>

                            <!-- File Upload Input Dropzone alternative -->
                            <div class="flex-1 w-full">
                                <label
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition"
                                >
                                    <div
                                        class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center"
                                    >
                                        <CloudArrowUpIcon
                                            class="w-8 h-8 text-slate-400 mb-2"
                                        />
                                        <p
                                            class="text-sm text-slate-600 font-semibold"
                                        >
                                            Click to replace photo
                                        </p>
                                        <p
                                            class="text-xs text-slate-400 mt-0.5"
                                        >
                                            PNG, JPG or GIF (MAX. 2MB)
                                        </p>
                                    </div>
                                    <input
                                        type="file"
                                        class="hidden"
                                        @input="
                                            form.image = $event.target.files[0]
                                        "
                                    />
                                </label>
                                <div
                                    v-if="form.errors.image"
                                    class="text-red-500 text-xs mt-1.5 font-medium"
                                >
                                    {{ form.errors.image }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Images Manager -->
                    <div class="mt-8 space-y-4">
                        <h3 class="text-lg font-bold text-gray-800">Adventure Images</h3>

                        <!-- Existing Gallery Images -->
                        <div v-if="adventure.images && adventure.images.length" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="image in adventure.images"
                                :key="image.id"
                                class="relative rounded-xl overflow-hidden border border-stone-200 h-32"
                            >
                                <img
                                    :src="'/storage/' + image.image"
                                    class="w-full h-full object-cover"
                                />
                                <span
                                    v-if="image.is_cover"
                                    class="absolute top-2 left-2 bg-green-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md"
                                >
                                    Cover
                                </span>
                                <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition flex items-center justify-center gap-2">
                                    <button
                                        @click="setCover(image.id)"
                                        type="button"
                                        class="text-xs bg-white/90 hover:bg-white text-gray-800 px-4 py-2.5 rounded-xl font-semibold"
                                    >
                                        Cover
                                    </button>
                                    <button
                                        @click="deleteImage(image.id)"
                                        type="button"
                                        class="text-xs bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl font-semibold"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Upload New Images -->
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6">
                            <label class="block font-semibold mb-2">Upload More Images</label>
                            <input
                                type="file"
                                multiple
                                accept="image/*"
                                @change="handleGalleryImages"
                                class="w-full p-2 border rounded"
                            />
                            <div v-if="form.errors.images" class="text-sm text-red-500 mt-1">
                                {{ form.errors.images }}
                            </div>

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
                    </div>

                    <!-- Submission Action Button -->
                    <div
                        class="pt-6 border-t border-slate-100 flex justify-end gap-4"
                    >
                        <Link
                            :href="route('adventures.index')"
                            class="px-6 py-3.5 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-green-700 hover:bg-green-800 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-green-700/20 transition duration-300 disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? "Updating Changes..."
                                    : "Save Updates"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
