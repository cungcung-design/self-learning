<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    images: Array,
    initialIndex: {
        type: Number,
        default: 0
    }
});

const emit = defineEmits(['close']);

const currentIndex = ref(props.initialIndex);

const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length;
};

const prevImage = () => {
    currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length;
};

const handleKeyDown = (e) => {
    if (e.key === 'Escape') emit('close');
    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
};

onMounted(() => window.addEventListener('keydown', handleKeyDown));
onUnmounted(() => window.removeEventListener('keydown', handleKeyDown));
</script>

<template>
    <div class="fixed inset-0 z-50 bg-black/90 flex flex-col items-center justify-center p-4">
        <!-- Close Button -->
        <button @click="emit('close')" class="absolute top-6 right-6 text-white text-2xl font-bold bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center transition">
            ✕
        </button>

        <!-- Main Image View -->
        <div class="relative max-w-5xl max-h-[80vh] flex items-center justify-center">
            <img :src="`/storage/${images[currentIndex].image}`" class="max-h-[80vh] max-w-full object-contain rounded-lg shadow-2xl" />

            <!-- Navigation Arrows -->
            <button @click="prevImage" class="absolute left-4 bg-black/50 hover:bg-black/75 text-white p-3 rounded-full text-xl transition">
                ◀
            </button>
            <button @click="nextImage" class="absolute right-4 bg-black/50 hover:bg-black/75 text-white p-3 rounded-full text-xl transition">
                ▶
            </button>
        </div>

        <!-- Image Counter Indicator -->
        <div class="text-white text-sm mt-4 font-medium tracking-wide">
            {{ currentIndex + 1 }} / {{ images.length }}
        </div>
    </div>
</template>
