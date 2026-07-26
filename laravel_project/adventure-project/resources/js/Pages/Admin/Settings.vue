<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Cog6ToothIcon } from "@heroicons/vue/24/outline";
</script>

<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900">Settings</h1>
                <p class="text-slate-500 text-sm mt-1">
                    Configure application settings.
                </p>
            </div>

            <div
                class="bg-white rounded-3xl shadow-xl border border-slate-100 p-12 text-center"
            >
                <div
                    class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100"
                >
                    <Cog6ToothIcon class="w-10 h-10 text-slate-300" />
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-1">
                    Settings Panel
                </h2>
                <p class="text-slate-400 text-sm max-w-md mx-auto">
                    Application settings and configuration options will be
                    available here in a future update.
                </p>
            </div>
        </div>
    </AdminLayout>
</template>
