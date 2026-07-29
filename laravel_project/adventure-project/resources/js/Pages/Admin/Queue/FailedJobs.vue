<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    failedJobs: Object,
});

const deleteForm = useForm({});

function retryJob(id) {
    deleteForm.post(`/admin/queue/failed/${id}/retry`, {
        onSuccess: () => {},
    });
}

function deleteJob(id) {
    if (confirm('Delete this failed job?')) {
        deleteForm.delete(`/admin/queue/failed/${id}/delete`, {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <AdminLayout>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Failed Queue Jobs</h1>
            <p class="text-sm text-gray-400 mt-1">Retry or remove failed background jobs.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
            <div v-if="failedJobs.data.length" class="divide-y divide-gray-100 dark:divide-gray-700">
                <div v-for="job in failedJobs.data" :key="job.id" class="p-4 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ job.id }}</span>
                        <span class="text-xs text-gray-400">{{ job.failed_at }}</span>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-200 font-medium">
                        {{ job.exception }}
                    </p>
                    <div class="flex gap-2">
                        <button @click="retryJob(job.id)" class="px-3 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">Retry</button>
                        <button @click="deleteJob(job.id)" class="px-3 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700 transition">Delete</button>
                    </div>
                </div>
            </div>

            <div v-else class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                No failed jobs found.
            </div>
        </div>
    </AdminLayout>
</template>
