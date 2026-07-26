<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <footer class="bg-slate-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                
                <div>
                    <h2 class="font-bold text-xl mb-4">🏔 Adventure Explorer</h2>
                    <p class="text-gray-400">
                        Discover mountains, rivers, forests, and unforgettable outdoor adventures.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><Link href="/" class="hover:text-white transition">Home</Link></li>
                        <li><Link href="/adventures" class="hover:text-white transition">Adventures</Link></li>
                        <li><Link href="/contact" class="hover:text-white transition">Contact</Link></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Us</h3>
                    <p class="text-gray-400">Email: info@adventure.com</p>
                    <p class="text-gray-400">Phone: +60 12-3456789</p>
                </div>

            </div>

            <hr class="my-8 border-slate-700">

            <p class="text-center text-gray-500 text-sm">
                © 2026 Adventure Explorer. All rights reserved.
            </p>
        </div>
    </footer>
</template>

