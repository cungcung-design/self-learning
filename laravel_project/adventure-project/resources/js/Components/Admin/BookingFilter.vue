<script setup>
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    filters: Object
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

watch([search, status], ([newSearch, newStatus]) => {
    router.get('/admin/bookings', { search: newSearch, status: newStatus }, {
        preserveState: true,
        replace: true
    });
});
</script>

<template>
    <div class="bg-white rounded-2xl shadow p-4 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <span class="font-bold text-gray-700">Filters</span>
        <div class="flex flex-wrap gap-3">
            <input 
                type="text" 
                v-model="search" 
                placeholder="Search customer..." 
                class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <select 
                v-model="status" 
                class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 capitalize"
            >
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>
</template>