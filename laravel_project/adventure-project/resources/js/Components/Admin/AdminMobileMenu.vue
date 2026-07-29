<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import NotificationBell from '@/Components/NotificationBell.vue';

const menuOpen = ref(false);
const page = usePage();

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
    {
        title: 'Activity Logs',
        icon: '📋',
        route: 'admin.activities.index',
    },
    {
        title: 'Support Chat',
        icon: '💬',
        route: 'admin.chat.index',
    },
    {
        title: 'Failed Jobs',
        icon: '⚠️',
        route: 'admin.queue.failed',
    },
];
</script>

<template>
    <div class="lg:hidden">
        <div class="flex items-center justify-between bg-slate-900 text-white px-4 py-3">
            <h1 class="text-xl font-bold">🏕 Adventure Admin</h1>
            <NotificationBell :notifications="page.props.auth?.user?.notifications || []" />
            <button @click="menuOpen = !menuOpen" class="text-white text-2xl font-bold p-2">
                {{ menuOpen ? '✕' : '☰' }}
            </button>
        </div>

        <div v-if="menuOpen" class="bg-slate-900 text-white px-4 py-4 space-y-1">
            <Link
                v-for="menu in menus"
                :key="menu.route"
                :href="route(menu.route)"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition"
            >
                <span class="text-xl">{{ menu.icon }}</span>
                <span class="font-medium">{{ menu.title }}</span>
            </Link>
        </div>
    </div>
</template>
