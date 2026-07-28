<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    activities: Object
});
</script>

<template>
    <AdminLayout>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📋 Admin Activity Logs</h1>
            <p class="text-sm text-gray-400 mt-1">Real-time security auditing and administrative action tracking.</p>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden p-6">
            <div class="space-y-6 divide-y divide-gray-100">
                <div v-for="activity in activities.data" :key="activity.id" class="pt-5 first:pt-0 flex flex-col md:flex-row md:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            {{ activity.description }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Executed by: <span class="font-semibold text-gray-700">{{ activity.causer?.name ?? 'System' }}</span>
                        </p>
                    </div>
                    <div class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1.5 rounded-xl self-start md:self-auto">
                        {{ new Date(activity.created_at).toLocaleString() }}
                    </div>
                </div>
                
                <div v-if="!activities.data.length" class="text-center py-8 text-gray-400 text-sm">
                    No activity logs recorded yet.
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
