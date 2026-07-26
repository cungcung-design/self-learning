<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import {
    ChartBarIcon,
    MapIcon,
    BookmarkSquareIcon,
    UsersIcon,
    Cog6ToothIcon,
    ArrowLeftOnRectangleIcon,
    Bars3Icon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

const sidebarOpen = ref(false);

const navigation = [
    { name: "Dashboard", href: route("admin.dashboard"), icon: ChartBarIcon },
    { name: "Adventures", href: route("adventures.index"), icon: MapIcon },
    {
        name: "Bookings",
        href: route("admin.bookings.index"),
        icon: BookmarkSquareIcon,
    },
    { name: "Users", href: route("admin.users.index"), icon: UsersIcon },
    {
        name: "Settings",
        href: route("admin.settings.index"),
        icon: Cog6ToothIcon,
    },
];

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Mobile sidebar overlay -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <div
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-green-800 text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto"
        >
            <div
                class="flex items-center justify-between px-6 py-5 border-b border-green-700"
            >
                <Link href="/" class="flex items-center space-x-2">
                    <span class="text-2xl">🏔️</span>
                    <span class="font-bold text-lg">Admin Panel</span>
                </Link>
                <button
                    @click="sidebarOpen = false"
                    class="lg:hidden text-white"
                >
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>

            <nav class="mt-4 px-3 space-y-1">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition"
                    :class="
                        route().current(item.href)
                            ? 'bg-green-700 text-white'
                            : 'text-green-100 hover:bg-green-700/50 hover:text-white'
                    "
                >
                    <component :is="item.icon" class="w-5 h-5" />
                    {{ item.name }}
                </Link>
            </nav>

            <div
                class="absolute bottom-0 left-0 right-0 p-4 border-t border-green-700"
            >
                <div class="flex items-center justify-between px-2">
                    <div class="text-sm">
                        <p class="font-medium">
                            {{ $page.props.auth?.user?.name }}
                        </p>
                        <p class="text-green-300 text-xs">Administrator</p>
                    </div>
                    <button
                        @click="logout"
                        class="p-2 rounded-lg hover:bg-green-700 transition"
                        title="Logout"
                    >
                        <ArrowLeftOnRectangleIcon
                            class="w-5 h-5 text-green-200"
                        />
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Bar -->
            <div
                class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200"
            >
                <div class="flex items-center justify-between px-6 py-3">
                    <button
                        @click="sidebarOpen = true"
                        class="lg:hidden text-gray-600"
                    >
                        <Bars3Icon class="w-6 h-6" />
                    </button>
                    <div class="flex items-center gap-4 ml-auto">
                        <Link
                            :href="route('home')"
                            class="text-sm text-gray-500 hover:text-green-700 transition"
                        >
                            View Site
                        </Link>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-600">{{
                            $page.props.auth?.user?.name
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
