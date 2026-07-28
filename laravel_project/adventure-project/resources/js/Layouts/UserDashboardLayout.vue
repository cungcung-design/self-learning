<script setup>
import { Link } from '@inertiajs/vue3'
import NotificationBell from '@/Components/NotificationBell.vue'
</script>

<template>
    <div class="min-h-screen bg-stone-50">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white min-h-screen p-6 hidden md:block border-r border-stone-100">
                <div class="flex items-center justify-between mb-10">
                    <h1 class="text-xl font-extrabold text-green-600 tracking-tight">
                        Adventure Explorer
                    </h1>
                    <NotificationBell :notifications="$page.props.auth?.user?.notifications || []" />
                </div>

                <nav class="mt-10 space-y-2">
                    <Link
                        href="/dashboard"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold transition-colors text-gray-600 hover:bg-green-50 hover:text-green-700"
                    >
                        <span>🏠</span>
                        <span>Dashboard</span>
                    </Link>

                    <Link
                        href="/profile"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold transition-colors text-gray-600 hover:bg-green-50 hover:text-green-700"
                    >
                        <span>👤</span>
                        <span>Profile</span>
                    </Link>

                    <Link
                        href="/bookings"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold transition-colors text-gray-600 hover:bg-green-50 hover:text-green-700"
                    >
                        <span>📅</span>
                        <span>My Bookings</span>
                    </Link>

                    <Link
                        href="/favorites"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold transition-colors text-gray-600 hover:bg-green-50 hover:text-green-700"
                    >
                        <span>❤️</span>
                        <span>Favorites</span>
                    </Link>
                </nav>
            </aside>

            <!-- Content Area -->
            <main class="flex-1 p-6 md:p-10">
                <slot />
            </main>
        </div>
    </div>
</template>