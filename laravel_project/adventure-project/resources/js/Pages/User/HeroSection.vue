<script setup>
import { Link } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'
import HeroSearch from '@/Components/HeroSearch.vue'

defineProps({
    image: {
        type: String,
        default: '/images/hero1.png'
    }
})
</script>

<template>
    <section
        class="hero-sec w-full"
        :style="{ backgroundImage: `url(${image.startsWith('http') || image.startsWith('/') ? image : '/' + image})` }"
    >
        <div class="relative z-10 h-full flex items-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            <div class="max-w-2xl mx-auto text-center home-text">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                    Discover Your Next Adventure
                </h1>

                <p class="text-lg sm:text-xl text-gray-200 mt-6">
                    Explore mountains, rivers, forests and unforgettable outdoor experiences.
                </p>

                <div class="mt-8">
                    <Link :href="route('adventures.index')">
                        <PrimaryButton>
                            Explore Adventures
                        </PrimaryButton>
                    </Link>
                </div>
            </div>
        </div>

        <HeroSearch />
    </section>
</template>