<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import UserRoleBadge from '@/Components/Admin/Users/UserRoleBadge.vue'
import UserStatus from '@/Components/Admin/Users/UserStatus.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({ user: Object })

const toggleStatus = () => {
    const newStatus = props.user.status === 'active' ? 'blocked' : 'active'
    router.patch(`/admin/users/${props.user.id}`, {
        role: props.user.role,
        status: newStatus
    }, { preserveScroll: true, only: ['user'] })
}

const toggleRole = () => {
    const newRole = props.user.role === 'admin' ? 'user' : 'admin'
    router.patch(`/admin/users/${props.user.id}`, {
        role: newRole,
        status: props.user.status
    }, { preserveScroll: true, only: ['user'] })
}

const deleteUser = () => {
    if (confirm('Are you sure you want to delete this user? All records will be removed.')) {
        router.delete(`/admin/users/${props.user.id}`)
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="bg-white rounded-2xl shadow p-8">
                <div class="flex justify-between items-center pb-6 border-b border-gray-100 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">👤 {{ user.name }}</h1>
                        <p class="text-sm text-gray-400">{{ user.email }}</p>
                    </div>
                    <div class="flex gap-2">
                        <UserRoleBadge :role="user.role" />
                        <UserStatus :status="user.status" />
                    </div>
                </div>

                <div class="flex gap-4">
                    <button @click="toggleStatus" class="px-4 py-2 rounded-xl text-sm font-semibold text-white" :class="user.status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'">
                        {{ user.status === 'active' ? 'Block User' : 'Unblock User' }}
                    </button>
                    <button @click="toggleRole" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold">
                        Toggle Role to {{ user.role === 'admin' ? 'User' : 'Admin' }}
                    </button>
                    <button @click="deleteUser" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-semibold ml-auto">
                        Delete User
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Booking History</h3>
                <div v-if="user.bookings?.length" class="space-y-3">
                    <div v-for="booking in user.bookings" :key="booking.id" class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                        <span class="font-semibold text-gray-700">{{ booking.adventure?.title }}</span>
                        <div class="text-sm space-x-4">
                            <span class="text-gray-500">Date: {{ booking.booking_date }}</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold uppercase" :class="booking.status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'">{{ booking.status }}</span>
                        </div>
                    </div>
                </div>
                <p v-else class="text-sm text-gray-400">No bookings recorded yet.</p>
            </div>
        </div>
    </AdminLayout>
</template>