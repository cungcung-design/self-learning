<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { useTheme } from "@/Composables/useTheme";

const menuOpen = ref(false);
const { darkMode, toggleTheme } = useTheme();
</script>

<template>
    <nav class="nav">
        <div class="nav-inner">
            <Link href="/" class="text-xl font-bold text-green-600 dark:text-green-400 tracking-tight">
                🏔 Adventure Explorer
            </Link>

            <div class="nav-center">
                <Link href="/" class="nav-link">Home</Link>
                <Link href="/adventures" class="nav-link">Adventures</Link>
                <Link href="/about" class="nav-link">About</Link>
                <Link href="/contact" class="nav-link">Contact</Link>
            </div>

            <div class="nav-auth">
                <template v-if="!$page.props.auth?.user">
                    <Link href="/login" class="btn btn-ghost btn-sm">Login</Link>
                    <Link href="/register" class="btn btn-primary btn-sm">Register</Link>
                </template>

                <template v-else>
                    <button @click="toggleTheme" class="btn btn-ghost btn-icon">
                        {{ darkMode ? '☀️' : '🌙' }}
                    </button>

                    <Link
                        v-if="$page.props.auth?.user?.role === 'admin'"
                        href="/admin/dashboard"
                        class="btn btn-admin btn-sm"
                    >
                        Admin Portal
                    </Link>

                    <Link href="/dashboard" class="nav-link">Dashboard</Link>
                    <Link :href="route('user.bookings.index')" class="nav-link">My Bookings</Link>
                    <Link href="/logout" method="post" as="button" class="btn btn-ghost btn-sm">Log Out</Link>
                </template>
            </div>

            <button @click="menuOpen = !menuOpen" class="mobile-only btn btn-ghost btn-icon-lg">
                ☰
            </button>
        </div>

        <div v-if="menuOpen" class="nav-mobile">
            <Link href="/" class="nav-mobile-link">Home</Link>
            <Link href="/adventures" class="nav-mobile-link">Adventures</Link>
            <Link href="/about" class="nav-mobile-link">About</Link>
            <Link href="/contact" class="nav-mobile-link">Contact</Link>

            <template v-if="!$page.props.auth?.user">
                <Link href="/login" class="nav-mobile-link">Login</Link>
                <Link href="/register" class="nav-mobile-link">Register</Link>
            </template>

            <template v-else>
                <Link href="/dashboard" class="nav-mobile-link">Dashboard</Link>
                <Link :href="route('user.bookings.index')" class="nav-mobile-link">My Bookings</Link>
                <Link href="/logout" method="post" as="button" class="nav-mobile-link">Log Out</Link>
            </template>
        </div>
    </nav>
</template>
