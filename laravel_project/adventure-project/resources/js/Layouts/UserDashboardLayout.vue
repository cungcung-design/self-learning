<script setup>
import { Link } from '@inertiajs/vue3'
import NotificationBell from '@/Components/NotificationBell.vue'
import '../../css/userDashboard.css'
</script>

<template>
    <div class="layout">
        <nav class="nav">
            <div class="nav-inner">
                <Link href="/" class="text-xl font-extrabold text-green-600 tracking-tight">
                    🏔 AdventureX
                </Link>

                <div class="nav-center">
                    <Link href="/" class="nav-link">Home</Link>
                    <Link href="/adventures" class="nav-link">Explore</Link>
                    <Link :href="route('user.bookings.index')" class="nav-link">My Bookings</Link>
                    <Link :href="route('user.favorites.index')" class="nav-link">Favorites</Link>
                    <Link :href="route('user.chat')" class="nav-link">💬 Chat</Link>
                </div>

                <div class="nav-auth">
                    <NotificationBell :notifications="$page.props.auth?.user?.notifications || []" />

                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-700 cursor-pointer">
                        <span>John Doe</span>
                        <span class="text-base">👤</span>
                        <span class="text-xs">▾</span>
                    </div>
                </div>
            </div>

            <div class="nav-mobile">
                <Link href="/" class="nav-mobile-link">Home</Link>
                <Link href="/adventures" class="nav-mobile-link">Explore</Link>
                <Link :href="route('user.bookings.index')" class="nav-mobile-link">My Bookings</Link>
                <Link :href="route('user.favorites.index')" class="nav-mobile-link">Favorites</Link>
                <Link :href="route('user.chat')" class="nav-mobile-link">💬 Chat</Link>
            </div>
        </nav>

        <main class="layout-main">
            <slot />
        </main>
    </div>
</template>
