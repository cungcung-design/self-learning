<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array
})
</script>

<template>
    <div v-if="links && links.length > 3" class="flex flex-wrap items-center justify-center gap-1.5 mt-10">
        <template v-for="(link, index) in links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                class="px-4 py-2 text-sm font-medium transition rounded-xl border shadow-sm inline-flex items-center justify-center"
                :class="{
                    'bg-green-700 text-white border-green-700 shadow-green-700/20': link.active,
                    'bg-white text-slate-700 border-stone-200 hover:bg-stone-50 hover:text-slate-900': !link.active,
                }"
            >
                <span v-html="link.label" />
            </Link>
            <span
                v-else
                class="px-4 py-2 text-sm font-medium text-stone-400 bg-stone-50 border border-stone-200 rounded-xl cursor-not-allowed select-none opacity-60 inline-flex items-center justify-center"
            >
                <span v-html="link.label" />
            </span>
        </template>
    </div>
</template>