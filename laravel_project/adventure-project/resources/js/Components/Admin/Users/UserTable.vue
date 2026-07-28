<script setup>
import { Link } from '@inertiajs/vue3'
import UserRoleBadge from './UserRoleBadge.vue'
import UserStatus from './UserStatus.vue'

defineProps({ users: Object })
</script>

<template>
    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50/70 text-gray-400 text-xs font-semibold uppercase tracking-wider border-b border-stone-100">
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">User</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-stone-50/50 transition-colors">
                        <td class="py-4 px-6 font-semibold text-gray-400">#{{ user.id }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs">
                                    {{ user.name.charAt(0) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ user.name }}</h4>
                                    <p class="text-xs text-gray-400 font-medium">{{ user.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <UserRoleBadge :role="user.role" />
                        </td>
                        <td class="py-4 px-6">
                            <UserStatus :status="user.status" />
                        </td>
                        <td class="py-4 px-6 text-right">
                            <Link
                                :href="route('admin.users.show', user.id)"
                                class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-stone-100 text-slate-700 hover:bg-emerald-600 hover:text-white transition-all shadow-sm"
                            >
                                View
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>