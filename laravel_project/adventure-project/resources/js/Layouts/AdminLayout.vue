<script setup>
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue'
</script>

<template>
    <div class="flex bg-gray-100 min-h-screen">

        <AdminSidebar />

        <main class="flex-1 p-8 overflow-y-auto">
            <slot />
        </main>

    </div>
</template>