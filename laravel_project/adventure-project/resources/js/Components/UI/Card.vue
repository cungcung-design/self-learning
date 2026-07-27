<!--
    Card UI component — a wrapper for consistent card styling.
    Provides a white background, rounded corners, shadow, and hover effect.
-->
<script setup>
defineProps({
    padding: {
        type: String,
        default: 'p-6',
    },
    hover: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div
        :class="[
            'bg-white rounded-2xl shadow-md border border-stone-100 overflow-hidden',
            padding,
            hover ? 'transition-all duration-300 hover:shadow-xl hover:-translate-y-1' : '',
        ]"
    >
        <slot />
    </div>
</template>

