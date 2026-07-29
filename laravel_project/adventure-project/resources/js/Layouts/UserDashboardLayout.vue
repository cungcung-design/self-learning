<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="min-h-screen bg-stone-50">
        <!-- Top Navbar -->
        <nav class="bg-white border-b border-stone-100 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <Link href="/" class="text-xl font-extrabold text-green-600 tracking-tight">
                        🏔 AdventureX
                    </Link>

                    <!-- Nav Links -->
                    <div class="hidden lg:flex items-center gap-6 text-sm font-semibold text-gray-600">
                        <Link href="/" class="hover:text-green-700 transition">Home</Link>
                        <Link href="/adventures" class="hover:text-green-700 transition">Explore</Link>
                        <Link :href="route('user.bookings.index')" class="hover:text-green-700 transition">My Bookings</Link>
                        <Link :href="route('user.favorites.index')" class="hover:text-green-700 transition">Favorites</Link>
                        <Link :href="route('user.chat')" class="hover:text-green-700 transition">💬 Chat</Link>
                    </div>

                    <!-- User Dropdown -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700 hidden sm:flex items-center gap-1">
                            John
                            <span class="text-base">👤</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div class="lg:hidden border-t border-stone-100 px-4 py-2 flex justify-around text-xs font-semibold text-gray-600">
                <Link href="/" class="hover:text-green-700">Home</Link>
                <Link href="/adventures" class="hover:text-green-700">Explore</Link>
                <Link :href="route('user.bookings.index')" class="hover:text-green-700">My Bookings</Link>
                <Link :href="route('user.favorites.index')" class="hover:text-green-700">Favorites</Link>
                <Link :href="route('user.chat')" class="hover:text-green-700">💬 Chat</Link>
            </div>
        </nav>

        <!-- Content Area -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-8">
            <slot />
        </main>
    </div>
</template>