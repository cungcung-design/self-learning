<script setup>
defineProps({
    status: String,
    remaining: Number,
});
</script>

<template>
    <span
        class="px-3 py-1 rounded-full text-xs font-semibold"
        :class="{
            'bg-green-100 text-green-700':
                status === 'available' && remaining > 5,
            'bg-yellow-100 text-yellow-700':
                status === 'available' && remaining <= 5,
            'bg-red-100 text-red-700':
                status === 'full' || status === 'cancelled',
        }"
    >
        <template v-if="status === 'full'">Sold Out</template>
        <template v-else-if="status === 'cancelled'">Cancelled</template>
        <template v-else>{{ remaining }} seats left</template>
    </span>
</template>
