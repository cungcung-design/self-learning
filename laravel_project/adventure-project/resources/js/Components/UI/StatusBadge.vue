<!--
    StatusBadge UI component.
    Displays a colored pill/badge for status indicators (e.g., confirmed, pending, cancelled).
-->
<script setup>
const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const statusClasses = {
    confirmed: 'bg-green-100 text-green-700',
    pending: 'bg-yellow-100 text-yellow-700',
    cancelled: 'bg-red-100 text-red-700',
    completed: 'bg-blue-100 text-blue-700',
    default: 'bg-gray-100 text-gray-700',
};

const badgeClass = statusClasses[props.status] || statusClasses.default;
</script>

<template>
    <span
        :class="badgeClass"
        class="inline-block text-xs font-semibold px-3 py-1 rounded-full capitalize"
    >
        {{ status }}
    </span>
</template>

