<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import UserTable from "@/Components/Admin/Users/UserTable.vue";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({ users: Object, filters: Object });

const search = ref(props.filters.search || "");
const role = ref(props.filters.role || "");

watch([search, role], ([newSearch, newRole]) => {
    router.get("/admin/users", { search: newSearch, role: newRole }, {
        preserveState: true,
        replace: true
    });
});
</script>

<template>
    <AdminLayout>
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
            <div class="flex gap-3">
                <input type="text" v-model="search" placeholder="Search user..." class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500" />
                <select v-model="role" class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm capitalize">
                    <option value="">All Roles</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <UserTable :users="users" />
    </AdminLayout>
</template>
