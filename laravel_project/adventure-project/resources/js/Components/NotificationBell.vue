<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    notifications: Array
});

const isOpen = ref(false);
const toggleDropdown = () => isOpen.value = !isOpen.value;
</script>

<template>
    <div class="relative">
        <button @click="toggleDropdown" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
            <span class="text-xl">🔔</span>
            <span v-if="notifications?.length" class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs font-bold">
                {{ notifications.length }}
            </span>
        </button>

        <div v-if="isOpen" class="absolute right-0 mt-3 bg-white shadow-xl rounded-2xl w-80 overflow-hidden z-50 border border-gray-100">
            <div class="p-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-700 text-sm">
                Notifications
            </div>
            <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                <div v-for="item in notifications" :key="item.id" class="p-4 hover:bg-gray-50 transition">
                    <h3 class="font-semibold text-sm text-gray-800">{{ item.data.title }}</h3>
                    <p class="text-xs text-gray-600 mt-1">{{ item.data.message }}</p>
                    <Link :href="`/notifications/${item.id}/read`" method="patch" as="button" class="text-[10px] text-blue-600 hover:underline mt-2 inline-block font-semibold">
                        Mark as read
                    </Link>
                </div>
                <div v-if="!notifications?.length" class="p-6 text-center text-xs text-gray-400">
                    No new notifications
                </div>
            </div>
        </div>
    </div>
</template>
