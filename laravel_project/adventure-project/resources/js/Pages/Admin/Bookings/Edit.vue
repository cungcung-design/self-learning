<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    booking: Object
});

const form = useForm({
    status: props.booking.status
});

const submit = () => {
    form.put(route('admin.bookings.update', props.booking.id));
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-2xl mx-auto px-6 py-12">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Booking #{{ booking.id }}</h1>
                <Link :href="route('admin.bookings.index')" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-600 hover:text-green-700 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm">
                    <ArrowLeftIcon class="w-4 h-4" /> Back
                </Link>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                        <select v-model="form.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-green-600 transition shadow-sm">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div v-if="form.errors.status" class="text-red-500 text-xs mt-1.5 font-medium">{{ form.errors.status }}</div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <Link :href="route('admin.bookings.index')" class="px-6 py-3 font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">Cancel</Link>
                        <button type="submit" :disabled="form.processing" class="bg-green-700 hover:bg-green-800 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition">Update Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>