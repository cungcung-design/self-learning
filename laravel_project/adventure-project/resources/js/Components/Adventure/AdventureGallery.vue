<script setup>
defineProps({
    adventure: Object,
})
</script>

<template>
    <div class="space-y-4">
        <!-- Large Main Image -->
        <div class="overflow-hidden rounded-3xl shadow-md bg-stone-100">
            <img
                :src="adventure.image"
                :alt="adventure.title"
                class="w-full h-[400px] object-cover"
            />
        </div>

        <!-- Thumbnails Row -->
        <div class="grid grid-cols-4 gap-4">
            <div v-for="i in 4" :key="i" class="overflow-hidden rounded-2xl bg-stone-100 h-24 border border-stone-200">
                <img
                    :src="adventure.image"
                    :alt="adventure.title"
                    class="w-full h-full object-cover opacity-80 hover:opacity-100 transition cursor-pointer"
                />
            </div>
        </div>
    </div>
</template>