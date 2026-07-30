<script setup>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
import MobileBottomNav from '@/Components/MobileBottomNav.vue'
</script>

<template>
    <div class="layout">
        <Navbar />

        <main class="layout-main">
            <slot />
        </main>

        <Footer />
        <MobileBottomNav />
    </div>
</template>
