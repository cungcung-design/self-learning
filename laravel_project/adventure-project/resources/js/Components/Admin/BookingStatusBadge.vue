<script setup>
defineProps({
    status: String
})
</script>

<template>
    <span
        class="px-3.5 py-1.5 rounded-full text-xs font-semibold capitalize inline-flex items-center gap-2 shadow-sm transition-all"
        :class="{
            'bg-yellow-50 text-yellow-700 border border-yellow-200/60': status === 'pending',
            'bg-emerald-50 text-emerald-700 border border-emerald-200/60': status === 'confirmed',
            'bg-rose-50 text-rose-700 border border-rose-200/60': status === 'cancelled',
            'bg-sky-50 text-sky-700 border border-sky-200/60': status === 'completed'
        }"
    >
        <span
            class="w-2 h-2 rounded-full ring-4"
            :class="{
                'bg-yellow-500 ring-yellow-400/20': status === 'pending',
                'bg-emerald-500 ring-emerald-400/20': status === 'confirmed',
                'bg-rose-500 ring-rose-400/20': status === 'cancelled',
                'bg-sky-500 ring-sky-400/20': status === 'completed'
            }"
        ></span>
        {{ status }}
    </span>
</template>