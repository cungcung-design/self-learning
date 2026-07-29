<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    adventure: Object,
    schedules: Object,
});

const deleteForm = useForm({});

function deleteSchedule(scheduleId) {
    if (confirm("Are you sure you want to delete this schedule?")) {
        deleteForm.delete(
            route("admin.adventures.schedules.destroy", [
                props.adventure.id,
                scheduleId,
            ]),
            {
                preserveScroll: true,
            }
        );
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-5xl py-12 px-6 mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Schedules
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Manage trip schedules for
                        <span class="font-semibold text-gray-700">
                            {{ adventure.title }}
                        </span>
                    </p>
                </div>
                <Link
                    :href="route('admin.adventures.schedules.create', adventure.id)"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-3 rounded-xl shadow-md transition duration-200 text-sm flex items-center gap-2"
                >
                    <span>+</span> Add Schedule
                </Link>
            </div>

            <!-- Schedules Table -->
            <div v-if="schedules.data.length > 0" class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <thead class="text-xs tracking-wider text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">Time</th>
                            <th class="px-6 py-3 font-semibold">Capacity</th>
                            <th class="px-6 py-3 font-semibold">Booked</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="schedule in schedules.data"
                            :key="schedule.id"
                            class="transition-colors hover:bg-gray-50/80"
                        >
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ schedule.trip_date }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ schedule.start_time }} - {{ schedule.end_time }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ schedule.capacity }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ schedule.booked }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full border inline-block capitalize"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700 border-emerald-200':
                                            schedule.status === 'available',
                                        'bg-amber-50 text-amber-700 border-amber-200':
                                            schedule.status === 'full',
                                        'bg-rose-50 text-rose-700 border-rose-200':
                                            schedule.status === 'cancelled',
                                    }"
                                >
                                    {{ schedule.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-3 text-right">
                                <Link
                                    :href="route('admin.adventures.schedules.edit', [adventure.id, schedule.id])"
                                    class="text-emerald-600 hover:text-emerald-900 font-medium text-xs bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="deleteSchedule(schedule.id)"
                                    :disabled="deleteForm.processing"
                                    class="text-rose-600 hover:text-rose-900 font-medium text-xs bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition disabled:opacity-50"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-20 bg-stone-50 rounded-3xl border border-stone-100 border-dashed"
            >
                <div class="mx-auto w-16 h-16 bg-green-50 text-green-600 flex items-center justify-center rounded-2xl mb-4 shadow-sm text-2xl">
                    📅
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">
                    No schedules found
                </h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                    Get started by creating your first trip schedule for this adventure.
                </p>
                <Link
                    :href="route('admin.adventures.schedules.create', adventure.id)"
                    class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition duration-200 text-sm"
                >
                    Create Schedule
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>
