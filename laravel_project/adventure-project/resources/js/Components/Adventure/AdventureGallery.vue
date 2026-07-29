<script setup>
import { ref, computed } from 'vue';
import GalleryModal from '@/Components/Gallery/GalleryModal.vue';

const props = defineProps({
    adventure: Object,
});

const showModal = ref(false);
const activeImageIndex = ref(0);

const images = computed(() => {
    if (props.adventure.images && props.adventure.images.length > 0) {
        return props.adventure.images;
    }
    if (props.adventure.image) {
        return [{ image: props.adventure.image, is_cover: true }];
    }
    return [];
});

const openGallery = (index) => {
    activeImageIndex.value = index;
    showModal.value = true;
};
</script>

<template>
    <div class="space-y-4">
        <!-- Large Main Image -->
        <div v-if="images.length" class="overflow-hidden rounded-3xl shadow-md bg-stone-100 cursor-pointer" @click="openGallery(0)">
            <img
                :src="`/storage/${images[0].image}`"
                :alt="adventure.title"
                class="w-full h-[400px] object-cover"
            />
        </div>

        <!-- Thumbnails Row -->
        <div v-if="images.length > 1" class="grid grid-cols-4 gap-4">
            <div v-for="(image, index) in images.slice(1, 5)" :key="image.id || index" class="overflow-hidden rounded-2xl bg-stone-100 h-24 border border-stone-200 cursor-pointer" @click="openGallery(index + 1)">
                <img
                    :src="`/storage/${image.image}`"
                    :alt="adventure.title"
                    class="w-full h-full object-cover opacity-80 hover:opacity-100 transition"
                />
            </div>
        </div>

        <!-- Fullscreen Gallery Modal -->
        <GalleryModal 
            v-if="showModal" 
            :images="images" 
            :initialIndex="activeImageIndex" 
            @close="showModal = false" 
        />
    </div>
</template>
