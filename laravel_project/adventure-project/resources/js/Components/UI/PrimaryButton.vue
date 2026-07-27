<!--
    This component is used by AdventureCard and other UI components.
    Styled with green theme matching the adventure project's design.
-->
<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-xl bg-green-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition duration-200 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 active:bg-green-900"
    >
        <slot />
    </button>
</template>

