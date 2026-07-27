<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="bg-gradient-to-r from-green-800 to-green-600 text-white py-24">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-extrabold mb-6 tracking-tight">
                Ready for Your Next Adventure?
            </h2>
            <p class="text-xl text-green-100 mb-10 max-w-2xl mx-auto">
                Book your experience today and create memories that will last a lifetime.
            </p>
            <Link
                href="/adventures"
                class="bg-orange-500 hover:bg-orange-600 px-10 py-4 rounded-xl text-lg font-semibold shadow-lg transition inline-block"
            >
                Book an Adventure
            </Link>
        </div>
    </section>
</template>

