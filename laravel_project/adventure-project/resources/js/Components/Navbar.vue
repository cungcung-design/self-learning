<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { useTheme } from "@/Composables/useTheme";

const menuOpen = ref(false);
const { darkMode, toggleTheme } = useTheme();
</script>

<template>
    <nav class="bg-white dark:bg-gray-800 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 shadow-sm sticky top-0 z-40 px-4 py-4 transition-colors duration-200">
        <div class="flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
            <Link href="/" class="text-xl font-bold text-green-600 dark:text-green-400 tracking-tight">
                🏔 Adventure Explorer
            </Link>

            <div class="hidden lg:flex items-center gap-6">
                <div class="hidden lg:flex gap-6 text-sm font-semibold text-gray-700 dark:text-gray-200">
                    <Link href="/" class="hover:text-green-600 dark:hover:text-green-400 transition">Home</Link>
                    <Link href="/adventures" class="hover:text-green-600 dark:hover:text-green-400 transition">Adventures</Link>
                    <Link href="/bookings" class="hover:text-green-600 dark:hover:text-green-400 transition">Bookings</Link>
                </div>

                <div class="flex items-center gap-3">
                    <template v-if="!$page.props.auth?.user">
                        <Link href="/login" class="text-green-700 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 font-semibold px-3 py-2">
                            Login
                        </Link>
                        <Link href="/register" class="bg-green-700 dark:bg-green-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-green-800 dark:hover:bg-green-500 transition shadow-sm">
                            Register
                        </Link>
                    </template>

                    <template v-else>
                        <button @click="toggleTheme" class="text-xl p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            {{ darkMode ? '☀️' : '🌙' }}
                        </button>

                        <Link
                            v-if="$page.props.auth?.user?.role === 'admin'"
                            href="/admin/dashboard"
                            class="bg-purple-50 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 hover:bg-purple-100 dark:hover:bg-purple-900/60 font-semibold transition px-4 py-2 rounded-xl text-sm border border-purple-200 dark:border-purple-700"
                        >
                            Admin Portal
                        </Link>

                        <Link href="/dashboard" class="hidden lg:inline-flex text-slate-600 dark:text-slate-300 hover:text-green-700 dark:hover:text-green-400 font-semibold transition px-3 py-2">
                            Dashboard
                        </Link>

                        <Link :href="route('user.bookings.index')" class="hidden lg:inline-flex text-slate-600 dark:text-slate-300 hover:text-green-700 dark:hover:text-green-400 font-semibold transition px-3 py-2">
                            My Bookings
                        </Link>
                        <Link href="/logout" method="post" as="button" class="hidden lg:inline-flex bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-slate-200 font-semibold px-5 py-2.5 rounded-xl hover:bg-slate-200 dark:hover:bg-gray-600 transition">
                            Log Out
                        </Link>
                    </template>
                </div>

                <button @click="menuOpen = !menuOpen" class="lg:hidden text-2xl text-gray-700 dark:text-gray-200 p-2 focus:outline-none">
                    ☰
                </button>
            </div>
        </div>

        <div v-if="menuOpen" class="lg:hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 space-y-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
            <Link href="/" class="block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Home</Link>
            <Link href="/adventures" class="block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Adventures</Link>
            <Link href="/bookings" class="block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Bookings</Link>

            <template v-if="!$page.props.auth?.user">
                <Link href="/login" class="block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Login</Link>
                <Link href="/register" class="block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Register</Link>
            </template>

            <template v-else>
                <Link href="/dashboard" class="lg:hidden block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</Link>
                <Link :href="route('user.bookings.index')" class="lg:hidden block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">My Bookings</Link>
                <Link href="/login" class="lg:hidden block px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">Log Out</Link>
            </template>
        </div>
    </nav>
</template>
