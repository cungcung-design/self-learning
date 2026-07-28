<script setup>
defineProps({ status: String })
</script>

<template>
    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize"
        :class="{
            'bg-green-100 text-green-700': status === 'active',
            'bg-red-100 text-red-700': status === 'blocked'
        }">
        {{ status }}
    </span>
</template>