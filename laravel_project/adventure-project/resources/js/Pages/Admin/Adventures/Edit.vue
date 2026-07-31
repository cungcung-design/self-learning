<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';
import { ref, onBeforeUnmount } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    adventure: Object,
    categories: Array,
});

const form = useForm({
    title: props.adventure.title || '',
    category_id: props.adventure.category_id || '',
    price: props.adventure.price || '',
    location: props.adventure.location || '',
    duration: props.adventure.duration || '',
    description: props.adventure.description || '',
    image: null,
    images: [],
    _method: 'PUT',
});

const previewImages = ref([]);
const previewCover = ref(null);

const handleGalleryChange = (e) => {
    previewImages.value.forEach((url) => URL.revokeObjectURL(url));
    previewImages.value = [];

    const files = Array.from(e.target.files);
    form.images = files;
    previewImages.value = files.map((file) => URL.createObjectURL(file));
};

const onCoverChange = (e) => {
    if (previewCover.value) {
        URL.revokeObjectURL(previewCover.value);
    }
    const file = e.target.files[0];
    form.image = file;
    previewCover.value = file ? URL.createObjectURL(file) : null;
};

onBeforeUnmount(() => {
    previewImages.value.forEach((url) => URL.revokeObjectURL(url));
    if (previewCover.value) {
        URL.revokeObjectURL(previewCover.value);
    }
});

// Helper function to reliably resolve image paths
const getImageUrl = (path) => {
    if (!path) return '';
    if (path.startsWith('http') || path.startsWith('blob:')) {
        return path;
    }
    // If path already includes storage/, don't duplicate it
    if (path.startsWith('storage/')) {
        return `/${path}`;
    }
    return `/storage/${path}`;
};

const submit = () => {
    form.post(route('admin.adventures.update', props.adventure.id), {
        onSuccess: () => {
            previewCover.value = null;
            router.visit(route('admin.adventures.index'));
        },
    });
};

const deleteThumbnail = (imageId) => {
    if (confirm('Delete this side image?')) {
        router.delete(route('adventures.images.destroy', [props.adventure.id, imageId]), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-6xl mx-auto space-y-6 pb-10 text-sm">

            <!-- Header -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h1 class="text-xl font-black text-gray-900 dark:text-white">
                        Edit Adventure <span class="text-xs text-gray-400 font-normal">#{{ adventure.id }}</span>
                    </h1>
                </div>
                <Link href="/admin/adventures" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-semibold">
                    ← Back
                </Link>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <form @submit.prevent="submit" class="space-y-4">

                    <!-- Title -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Title</label>
                        <input type="text" v-model="form.title" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required />
                    </div>

                    <!-- Category & Price -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Category</label>
                            <select v-model="form.category_id" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required>
                                <option value="" disabled>Select</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Price (RM)</label>
                            <input type="number" step="0.01" v-model="form.price" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required />
                        </div>
                    </div>

                    <!-- Location & Duration -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Location</label>
                            <input type="text" v-model="form.location" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Duration</label>
                            <input type="text" v-model="form.duration" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required />
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Description</label>
                        <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white text-xs focus:ring-1 focus:ring-green-500" required></textarea>
                    </div>

<!-- Main Cover Image -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-900/40 rounded-xl space-y-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500">Main Cover Image</label>

                        <div v-if="previewCover || adventure.image" class="flex items-center gap-3">
                            <img
                                :src="previewCover || getImageUrl(adventure.image)"
                                class="w-28 h-20 rounded-lg object-cover border border-gray-200 dark:border-gray-700 shadow-sm"
                                alt="Cover Preview"
                            />
                            <span class="text-[11px] text-gray-400">
                                {{ previewCover ? 'New cover preview' : 'Current active cover photo' }}
                            </span>
                        </div>

                        <input type="file" @change="onCoverChange" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-green-50 file:text-green-700 dark:file:bg-green-900/30 dark:file:text-green-400 cursor-pointer" />
                        <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
                    </div>
<!-- Gallery Side Images -->
<div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl space-y-3">
    <div class="flex justify-between items-center">
        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500">
            Gallery Side Images (Multiple)
        </label>

        <span class="text-[10px] bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold px-2 py-0.5 rounded-full">
            {{ (adventure.images?.length || 0) + previewImages.length }} Active
        </span>
    </div>

    <!-- slider images -->
    <div
        v-if="adventure.images?.length || previewImages.length"
        class="grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 gap-2"
    >
        <div
            v-for="img in adventure.images"
            :key="img.id"
            class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm"
        >
            <img
                :src="getImageUrl(img.image)"
                class="w-full h-20 object-cover"
                alt="Side Image"
            />

            <button
                type="button"
                @click="deleteThumbnail(img.id)"
                class="absolute top-1 right-1 bg-red-600 text-white p-1 rounded text-[9px] shadow opacity-80 hover:opacity-100 transition"
            >
                ❌
            </button>
        </div>

        <div
            v-for="(preview, index) in previewImages"
            :key="index"
            class="relative group rounded-lg overflow-hidden border border-blue-300 bg-white dark:bg-gray-800 shadow-sm"
        >
            <img
                :src="preview"
                class="w-full h-20 object-cover"
                alt="New preview"
            />
            <div class="absolute top-1 left-1 bg-blue-600 text-white p-0.5 rounded text-[8px] font-bold">
                NEW
            </div>
        </div>
    </div>

    <p
        v-if="!adventure.images?.length && !previewImages.length"
        class="text-[11px] text-gray-400 italic"
    >
        No side images uploaded yet.
    </p>

    <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
        <input
            type="file"
            multiple
            @change="handleGalleryChange"
            class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400 cursor-pointer"
        />

        <span class="text-[10px] text-gray-400 mt-1 block">
            Hold Ctrl or Cmd to select multiple files to upload simultaneously.
        </span>

        <div
            v-if="form.errors.images"
            class="text-red-500 text-xs mt-1"
        >
            {{ form.errors.images }}
        </div>
    </div>
</div>
                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <Link href="/admin/adventures" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold">Cancel</Link>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-sm transition disabled:opacity-50">Save</button>
                    </div>

                </form>
            </div>

        </div>
    </AdminLayout>
</template>