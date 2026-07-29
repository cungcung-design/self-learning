<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    adventure: Object,
    schedule: Object,
});

const form = useForm({
    trip_date: props.schedule.trip_date || "",
    start_time: props.schedule.start_time || "",
    end_time: props.schedule.end_time || "",
    capacity: props.schedule.capacity || "",
    status: props.schedule.status || "available",
    _method: "PUT",
});

const submit = () => {
    form.post(
        route("admin.adventures.schedules.update", [
            props.adventure.id,
            props.schedule.id,
        ])
    );
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
            <h1 class="mb-6 text-3xl font-bold">
                Edit Schedule for {{ adventure.title }}
            </h1>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div>
                    <label class="block font-semibold mb-1">Trip Date</label>
                    <input
                        type="date"
                        v-model="form.trip_date"
                        class="w-full border p-2 rounded"
                    />
                    <div v-if="form.errors.trip_date" class="text-sm text-red-500">
                        {{ form.errors.trip_date }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Start Time</label>
                        <input
                            type="time"
                            v-model="form.start_time"
                            class="w-full border p-2 rounded"
                        />
                        <div v-if="form.errors.start_time" class="text-sm text-red-500">
                            {{ form.errors.start_time }}
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">End Time</label>
                        <input
                            type="time"
                            v-model="form.end_time"
                            class="w-full border p-2 rounded"
                        />
                        <div v-if="form.errors.end_time" class="text-sm text-red-500">
                            {{ form.errors.end_time }}
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Capacity</label>
                    <input
                        type="number"
                        v-model="form.capacity"
                        min="1"
                        class="w-full border p-2 rounded"
                    />
                    <div v-if="form.errors.capacity" class="text-sm text-red-500">
                        {{ form.errors.capacity }}
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Status</label>
                    <select v-model="form.status" class="w-full border p-2 rounded">
                        <option value="available">Available</option>
                        <option value="full">Full</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <div v-if="form.errors.status" class="text-sm text-red-500">
                        {{ form.errors.status }}
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="p-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 disabled:opacity-50"
                >
                    {{ form.processing ? "Updating..." : "Update Schedule" }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
