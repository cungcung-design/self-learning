<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import MobileBottomNav from "@/Components/MobileBottomNav.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 dark:text-gray-100 flex flex-col transition-colors duration-200">
        <Navbar />

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 pb-24 lg:pb-6 max-w-7xl mx-auto w-full">
            <slot />
        </main>

        <Footer />
        <MobileBottomNav />
    </div>
</template>
