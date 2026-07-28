<script setup>
defineProps({
    role: String
})
</script>

<template>
    <span
        class="inline-flex w-20 justify-center rounded-full px-3 py-1 text-xs font-semibold capitalize"
        :class="{
            'bg-purple-100 text-purple-700': role === 'admin',
            'bg-gray-100 text-gray-700': role === 'user'
        }"
    >
        {{ role }}
    </span>
</template>