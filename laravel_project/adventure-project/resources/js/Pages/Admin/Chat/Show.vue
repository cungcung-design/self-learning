<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    conversation: Object,
});

const form = useForm({
    message: '',
});

function reply() {
    form.post(`/chat/${conversation.id}/reply`, {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-3xl">
            <div class="mb-6">
                <Link href="/admin/chat" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                    ← Back to conversations
                </Link>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    💬 Conversation with {{ conversation.user?.name }}
                </h1>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <div class="h-96 overflow-y-auto space-y-4 mb-6">
                    <div
                        v-for="msg in conversation.messages"
                        :key="msg.id"
                        class="p-4 rounded-xl border border-gray-100 dark:border-gray-700"
                        :class="msg.user_id === $page.props.auth?.user?.id ? 'bg-green-50 dark:bg-green-900/30 ml-8' : 'bg-gray-50 dark:bg-gray-700 mr-8'"
                    >
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                            {{ msg.user?.name }}
                        </p>
                        <p class="dark:text-white mt-1">{{ msg.message }}</p>
                    </div>
                </div>

                <div>
                    <textarea
                        v-model="form.message"
                        rows="3"
                        class="w-full border rounded-lg p-3 dark:bg-gray-700 dark:text-white"
                        placeholder="Type your reply..."
                    ></textarea>
                    <button
                        @click="reply"
                        :disabled="form.processing"
                        class="mt-3 bg-emerald-600 text-white px-5 py-3 rounded-xl disabled:opacity-50"
                    >
                        Send Reply
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
