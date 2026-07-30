<script setup>
import { ref } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import NotificationBell from '@/Components/NotificationBell.vue';
import { useTheme } from '@/Composables/useTheme';

const menuOpen = ref(false);
const page = usePage();
const { darkMode, toggleTheme } = useTheme();

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

const handleLogout = () => {
    router.post('/logout')
}
</script>

<template>
    <div class="md:hidden">
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

            <div class="pt-4 mt-4 border-t border-slate-700 space-y-1">
                <button
                    @click="toggleTheme"
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition"
                >
                    <span class="text-xl">{{ darkMode ? '☀️' : '🌙' }}</span>
                    <span class="font-medium">{{ darkMode ? 'Light Mode' : 'Dark Mode' }}</span>
                </button>

                <button
                    @click="handleLogout"
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-300 hover:bg-red-900/30 hover:text-red-400 transition"
                >
                    <span class="text-xl">🚪</span>
                    <span class="font-medium">Logout</span>
                </button>
            </div>
        </div>
    </div>
</template>
