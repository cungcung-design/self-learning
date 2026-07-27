<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/vue3";
import {
    MapIcon,
    BookmarkSquareIcon,
    UsersIcon,
    BanknotesIcon,
} from "@heroicons/vue/24/outline";

defineProps({ stats: Object });
</script>

<template>
    <AdminLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl font-extrabold mb-10">Admin Dashboard</h1>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <Link
                    :href="route('admin.adventures.index')"
                    class="bg-white p-6 rounded-3xl shadow-xl flex items-center justify-between hover:shadow-2xl hover:scale-105 transition-all duration-200 cursor-pointer"
                >
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Adventures
                        </p>
                        <h2 class="text-3xl font-extrabold">
                            {{ stats.adventures }}
                        </h2>
                    </div>
                    <MapIcon class="w-8 h-8 text-green-700" />
                </Link>
                <Link
                    :href="route('admin.bookings.index')"
                    class="bg-white p-6 rounded-3xl shadow-xl flex items-center justify-between hover:shadow-2xl hover:scale-105 transition-all duration-200 cursor-pointer"
                >
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Bookings
                        </p>
                        <h2 class="text-3xl font-extrabold">
                            {{ stats.bookings }}
                        </h2>
                    </div>
                    <BookmarkSquareIcon class="w-8 h-8 text-blue-600" />
                </Link>
                <Link
                    :href="route('admin.users.index')"
                    class="bg-white p-6 rounded-3xl shadow-xl flex items-center justify-between hover:shadow-2xl hover:scale-105 transition-all duration-200 cursor-pointer"
                >
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Users
                        </p>
                        <h2 class="text-3xl font-extrabold">
                            {{ stats.users }}
                        </h2>
                    </div>
                    <UsersIcon class="w-8 h-8 text-orange-600" />
                </Link>
                <div
                    class="bg-white p-6 rounded-3xl shadow-xl flex items-center justify-between"
                >
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Revenue
                        </p>
                        <h2 class="text-3xl font-extrabold text-emerald-700">
                            RM {{ stats.revenue }}
                        </h2>
                    </div>
                    <BanknotesIcon class="w-8 h-8 text-emerald-600" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
