<script setup>
import { Link } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/UI/PrimaryButton.vue'
</script>

<template>
<section
class="relative bg-cover bg-center h-[650px]"
style="background-image:url('/images/hero.jpg')"
>

<div class="absolute inset-0 bg-black/50"></div>

<div
class="relative z-10 max-w-7xl mx-auto h-full flex items-center px-6"
>

<div class="max-w-2xl">

<h1
class="text-5xl md:text-6xl font-extrabold text-white leading-tight"
>
Discover Your Next Adventure
</h1>

<p
class="text-xl text-gray-200 mt-6"
>
Explore mountains, rivers, forests and unforgettable outdoor experiences.
</p>

<div class="mt-8">

<Link :href="route('adventures.index')">

<PrimaryButton>

Explore Adventures

</PrimaryButton>

</Link>

</div>

</div>

</div>

</section>
</template>