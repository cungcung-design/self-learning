<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 md:hidden flex justify-around items-center py-3 z-50 shadow-lg">
        <Link href="/" class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
            <span class="text-lg">🏠</span>
            <p class="text-[10px] font-semibold mt-0.5">Home</p>
        </Link>
        <Link href="/adventures" class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
            <span class="text-lg">🔍</span>
            <p class="text-[10px] font-semibold mt-0.5">Search</p>
        </Link>
        <Link href="/bookings" class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
            <span class="text-lg">📖</span>
            <p class="text-[10px] font-semibold mt-0.5">Bookings</p>
        </Link>
        <Link href="/chat" class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
            <span class="text-lg">💬</span>
            <p class="text-[10px] font-semibold mt-0.5">Chat</p>
        </Link>
        <Link href="/profile" class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
            <span class="text-lg">👤</span>
            <p class="text-[10px] font-semibold mt-0.5">Profile</p>
        </Link>
    </div>
</template>
