<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <footer class="footer ">
        <div class="footer-inner">
            <div class="footer-grid">
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
                    <p class="text-gray-400">Phone: +60 12-345-6789</p>
                </div>

            </div>

            <div class="footer-divider"></div>

            <p class="footer-copy">
                © 2026 Adventure Explorer. All rights reserved.
            </p>
        </div>
    </footer>
</template>
