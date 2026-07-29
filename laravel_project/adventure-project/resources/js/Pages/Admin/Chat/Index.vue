<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    conversations: Object,
});
</script>

<template>
    <AdminLayout>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">💬 Customer Support</h1>
            <p class="text-sm text-gray-400 mt-1">Reply to customer conversations.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
            <div v-if="conversations.data.length" class="divide-y divide-gray-100 dark:divide-gray-700">
                <div
                    v-for="conversation in conversations.data"
                    :key="conversation.id"
                    class="p-4 flex justify-between items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                >
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">
                            {{ conversation.user?.name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ conversation.messages?.last?.message ?? 'No messages' }}
                        </p>
                    </div>
                    <Link
                        :href="route('admin.chat.show', conversation.id)"
                        class="text-emerald-600 hover:text-emerald-900 font-medium text-xs bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition"
                    >
                        Reply
                    </Link>
                </div>
            </div>

            <div v-else class="p-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                No conversations yet.
            </div>
        </div>
    </AdminLayout>
</template>
