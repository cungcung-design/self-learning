<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link } from "@inertiajs/vue3";
import FeaturedSection from "@/Pages/User/FeaturedSection.vue";

defineProps({
    adventures: Array,
});
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-r from-green-800 to-green-600 text-white py-32"
        >
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h1 class="text-6xl font-extrabold mb-6 tracking-tight">
                    Discover Your Next Adventure
                </h1>
                <p class="text-xl mb-10 text-green-100 max-w-2xl mx-auto">
                    Explore the best hiking, camping, kayaking, and outdoor
                    experiences tailored for explorers.
                </p>
                <Link
                    href="/adventures"
                    class="bg-orange-500 hover:bg-orange-600 px-8 py-4 rounded-xl text-lg font-semibold shadow-lg transition inline-block"
                >
                    Explore Adventures
                </Link>
            </div>
        </section>

        <!-- Featured Adventures Section -->
        <FeaturedSection :adventures="adventures" />
    </MainLayout>
</template>
