<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const isActive = (routeName) => route().current(routeName)

const componentName = computed(() => page.component)

const menus = [
    {
        title: 'Dashboard',
        icon: '📊',
        route: 'admin.dashboard',
        component: 'Admin/Dashboard',
    },
    {
        title: 'Adventures',
        icon: '🏔️',
        route: 'admin.adventures.index',
        component: 'Admin/Adventures/Index',
    },
    {
        title: 'Categories',
        icon: '📂',
        route: 'admin.categories.index',
        component: 'Admin/Categories/AdminCategory',
    },
    {
        title: 'Bookings',
        icon: '📅',
        route: 'admin.bookings.index',
        component: 'Admin/Bookings/Index',
    },
    {
        title: 'Users',
        icon: '👥',
        route: 'admin.users.index',
        component: 'Admin/Users/Index',
    },
    {
        title: 'Reviews',
        icon: '⭐',
        route: 'admin.reviews.index',
        component: 'Admin/Reviews/Index',
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
                :class="componentName.startsWith(menu.component)
                    ? 'bg-green-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800'"
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