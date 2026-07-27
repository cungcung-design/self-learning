<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const isActive = (routeName) => {
    return route().current(routeName)
}

const menus = [
    {
        title: 'Dashboard',
        icon: '📊',
        route: 'admin.dashboard',
    },
    {
        title: 'Adventures',
        icon: '🏔️',
        route: 'admin.adventures.index',
    },
    {
        title: 'Categories',
        icon: '📂',
        route: 'admin.categories.index',
    },
    {
        title: 'Bookings',
        icon: '📅',
        route: 'admin.bookings.index',
    },
    {
        title: 'Users',
        icon: '👥',
        route: 'admin.users.index',
    },
    {
        title: 'Reviews',
        icon: '⭐',
        route: 'admin.reviews.index',
    },
    {
        title: 'Reports',
        icon: '📈',
        route: 'admin.reports.index',
    },
]
</script>

<template>
    <aside class="w-64 min-h-screen bg-slate-900 text-white">

        <!-- Logo -->
        <div class="px-6 py-8 border-b border-slate-700">
            <h1 class="text-2xl font-bold">
                🏕 Adventure Admin
            </h1>
        </div>

        <!-- Navigation -->
        <nav class="mt-6">

            <Link
                v-for="menu in menus"
                :key="menu.route"
                :href="route(menu.route)"
                class="flex items-center gap-4 px-6 py-4 transition duration-200"
                :class="isActive(menu.route)
                    ? 'bg-green-600 text-white'
                    : 'hover:bg-slate-800 text-slate-300'"
            >
                <span class="text-xl">
                    {{ menu.icon }}
                </span>

                <span>
                    {{ menu.title }}
                </span>
            </Link>

        </nav>

        <!-- Bottom -->
        <div class="absolute bottom-0 w-64 border-t border-slate-700 p-6">
            <p class="text-sm text-slate-400">
                Adventure Explorer
            </p>

            <p class="text-xs text-slate-500">
                Admin Panel v1.0
            </p>
        </div>

    </aside>
</template>