<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    user: Object,
});

const form = useForm({
    role: props.user.role,
    status: props.user.status,
});

const submit = () => {
    form.patch(route("admin.users.update", props.user.id));
};
</script>

<template>
    <AdminLayout>
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">
                        Edit User
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">
                        Update user role and status.
                    </p>
                </div>
                <Link
                    :href="route('admin.users.index')"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-green-700 bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm transition"
                >
                    <ArrowLeftIcon class="w-4 h-4" /> Back
                </Link>
            </div>

            <div
                class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                            >Role</label
                        >
                        <select
                            v-model="form.role"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:ring-2 focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        >
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div
                            v-if="form.errors.role"
                            class="text-red-500 text-xs mt-1.5"
                        >
                            {{ form.errors.role }}
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                            >Status</label
                        >
                        <select
                            v-model="form.status"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-slate-900 font-medium focus:ring-2 focus:ring-green-600 focus:border-green-600 transition shadow-sm"
                        >
                            <option value="active">Active</option>
                            <option value="blocked">Blocked</option>
                        </select>
                        <div
                            v-if="form.errors.status"
                            class="text-red-500 text-xs mt-1.5"
                        >
                            {{ form.errors.status }}
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-4">
                        <Link
                            :href="route('admin.users.index')"
                            class="px-6 py-3.5 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition"
                            >Cancel</Link
                        >
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-green-700 hover:bg-green-800 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg transition disabled:opacity-50"
                        >
                            {{ form.processing ? "Saving..." : "Update User" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
