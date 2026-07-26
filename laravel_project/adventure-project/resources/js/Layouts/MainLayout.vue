<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <div class="bg-stone-50 min-h-screen flex flex-col">
        <Navbar />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>
