<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    conversation: Object,
});

const form = useForm({
    message: '',
});

function send() {
    form.post('/chat/send', {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <MainLayout>
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-5">
            <h1 class="text-2xl font-bold dark:text-white">
                💬 Support Chat
            </h1>

            <div class="h-96 overflow-y-auto mt-5 space-y-3">
                <div
                    v-for="msg in conversation?.messages"
                    :key="msg.id"
                    class="mb-3 p-3 rounded-xl border border-gray-100 dark:border-gray-700"
                    :class="msg.user_id === $page.props.auth?.user?.id ? 'bg-green-50 dark:bg-green-900/30 ml-8' : 'bg-gray-50 dark:bg-gray-700 mr-8'"
                >
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        {{ msg.user?.name }}
                    </p>
                    <p class="dark:text-white mt-1">{{ msg.message }}</p>
                </div>

                <div v-if="!conversation?.messages?.length" class="text-center py-8 text-gray-500 dark:text-gray-400 text-sm">
                    No messages yet. Start the conversation below.
                </div>
            </div>

            <div class="mt-4">
                <input
                    v-model="form.message"
                    class="w-full border rounded-lg p-3 dark:bg-gray-700 dark:text-white"
                    placeholder="Type message..."
                />
                <button
                    @click="send"
                    :disabled="form.processing"
                    class="mt-3 bg-green-600 text-white px-5 py-3 rounded-xl disabled:opacity-50"
                >
                    Send
                </button>
            </div>
        </div>
    </MainLayout>
</template>
