<script setup>
defineProps({
    bookings: Array
})
</script>

<template>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Recent Bookings</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="py-3 px-6">ID</th>
                        <th class="py-3 px-6">Customer</th>
                        <th class="py-3 px-6">Adventure</th>
                        <th class="py-3 px-6">Date</th>
                        <th class="py-3 px-6">Participants</th>
                        <th class="py-3 px-6">Total Price</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    <tr v-for="booking in bookings" :key="booking.id" class="hover:bg-gray-50/50">
                        <td class="py-4 px-6 font-medium">#{{ booking.id }}</td>
                        <td class="py-4 px-6 font-semibold text-gray-800">{{ booking.user?.name }}</td>
                        <td class="py-4 px-6">{{ booking.adventure?.title }}</td>
                        <td class="py-4 px-6">{{ booking.date }}</td>
                        <td class="py-4 px-6">{{ booking.participants }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">RM {{ booking.total_price }}</td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                :class="{
                                    'bg-yellow-100 text-yellow-700': booking.status === 'pending',
                                    'bg-green-100 text-green-700': booking.status === 'confirmed',
                                    'bg-red-100 text-red-700': booking.status === 'cancelled'
                                }">
                                {{ booking.status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a :href="`/admin/bookings/${booking.id}`" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>