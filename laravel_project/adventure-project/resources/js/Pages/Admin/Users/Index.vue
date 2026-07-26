<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import {
    UsersIcon,
    PencilSquareIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    users: Object,
});

const deleteUser = (user) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        router.delete(route("admin.users.destroy", user.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">
                        User Management
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Manage all registered platform users.
                    </p>
                </div>
            </div>

            <div
                class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider"
                        >
                            <tr>
                                <th class="p-5 font-bold">Name</th>
                                <th class="p-5 font-bold">Email</th>
                                <th class="p-5 font-bold">Role</th>
                                <th class="p-5 font-bold">Joined</th>
                                <th class="p-5 font-bold text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <tr
                                v-for="user in users.data"
                                :key="user.id"
                                class="hover:bg-slate-50 transition"
                            >
                                <td class="p-5 font-medium text-slate-900">
                                    {{ user.name }}
                                </td>
                                <td class="p-5 text-slate-600">
                                    {{ user.email }}
                                </td>
                                <td class="p-5">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-xl text-xs font-bold"
                                        :class="
                                            user.role === 'admin'
                                                ? 'bg-purple-50 text-purple-700 border border-purple-200'
                                                : 'bg-green-50 text-green-700 border border-green-200'
                                        "
                                    >
                                        {{ user.role }}
                                    </span>
                                </td>
                                <td class="p-5 text-slate-500">
                                    {{
                                        new Date(
                                            user.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="p-5 text-right space-x-2">
                                    <Link
                                        :href="
                                            route('admin.users.edit', user.id)
                                        "
                                        class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold px-3 py-2 rounded-xl transition text-xs"
                                    >
                                        <PencilSquareIcon class="w-4 h-4" />
                                        Edit
                                    </Link>
                                    <button
                                        @click="deleteUser(user)"
                                        class="inline-flex items-center gap-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold px-3 py-2 rounded-xl transition text-xs"
                                    >
                                        <TrashIcon class="w-4 h-4" /> Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="users.data.length === 0">
                                <td
                                    colspan="5"
                                    class="p-20 text-center text-slate-400"
                                >
                                    <UsersIcon
                                        class="w-12 h-12 mx-auto mb-3 text-slate-300"
                                    />
                                    <p class="text-lg font-bold text-slate-800">
                                        No users found
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
