<script setup>
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue'
import AdminMobileMenu from '@/Components/Admin/AdminMobileMenu.vue'
</script>

<template>
    <div class="flex bg-gray-100 dark:bg-gray-900 min-h-screen transition-colors duration-200">
        <div class="hidden lg:block">
            <AdminSidebar />
        </div>
        <AdminMobileMenu />

        <main class="flex-1 p-4 lg:p-8 xl:p-12 2xl:p-16 overflow-y-auto">
            <slot />
        </main>
    </div>
</template>
