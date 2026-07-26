<script setup>
import { Link } from "@inertiajs/vue3";
import { Bars3Icon } from "@heroicons/vue/24/outline";
</script>

<template>
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <Link href="/" class="flex items-center space-x-2">
                    <span class="text-3xl">🏔️</span>
                    <div>
                        <h1 class="font-bold text-xl text-green-700">
                            Adventure Explorer
                        </h1>
                    </div>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link
                        href="/"
                        class="text-gray-700 hover:text-green-700 transition"
                        >Home</Link
                    >
                    <Link
                        href="/adventures"
                        class="text-gray-700 hover:text-green-700 transition"
                        >Adventures</Link
                    >
                    <Link
                        href="/categories"
                        class="text-gray-700 hover:text-green-700 transition"
                        >Categories</Link
                    >
                    <Link
                        href="/about"
                        class="text-gray-700 hover:text-green-700 transition"
                        >About</Link
                    >
                    <Link
                        href="/contact"
                        class="text-gray-700 hover:text-green-700 transition"
                        >Contact</Link
                    >
                </div>

                <!-- Right Side Actions -->
                <div class="hidden md:flex items-center space-x-3">
                    <!-- If User is NOT logged in -->
                    <template v-if="!$page.props.auth?.user">
                        <Link
                            href="/login"
                            class="text-green-700 hover:text-green-800 font-semibold px-3 py-2"
                        >
                            Login
                        </Link>
                        <Link
                            href="/register"
                            class="bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-green-800 transition shadow-sm"
                        >
                            Register
                        </Link>
                    </template>

                    <!-- If User IS logged in -->
                    <template v-else>
                        <!-- Admin Control Link (Only shows if role is admin) -->
                        <Link
                            v-if="$page.props.auth?.user?.role === 'admin'"
                            href="/admin/dashboard"
                            class="bg-purple-50 text-purple-700 hover:bg-purple-100 font-semibold transition px-4 py-2 rounded-xl text-sm border border-purple-200"
                        >
                            Admin Portal
                        </Link>

                        <Link
                            href="/dashboard"
                            class="text-slate-600 hover:text-green-700 font-semibold transition px-3 py-2"
                        >
                            Dashboard
                        </Link>

                        <Link
                            :href="route('user.bookings.index')"
                            class="text-slate-600 hover:text-green-700 font-semibold transition px-3 py-2"
                        >
                            My Bookings
                        </Link>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="bg-slate-100 text-slate-700 font-semibold px-5 py-2.5 rounded-xl hover:bg-slate-200 transition"
                        >
                            Log Out
                        </Link>
                    </template>
                </div>
                <!-- Mobile Button -->
                <button class="md:hidden text-green-700 focus:outline-none">
                    <Bars3Icon class="h-7 w-7" />
                </button>
            </div>
        </div>
    </nav>
</template>
