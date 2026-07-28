<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BookingTable from "@/Components/Admin/BookingTable.vue";
import BookingFilter from "@/Components/Admin/BookingFilter.vue";

defineProps({
    bookings: Object,
    filters: Object
});
</script>

<template>
    <AdminLayout>
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Booking Management</h1>
                <p class="text-gray-500 text-sm mt-1">Review, approve, or cancel incoming customer reservation requests.</p>
            </div>
        </div>

        <BookingFilter :filters="filters" />
        <BookingTable :bookings="bookings" />
    </AdminLayout>
</template>