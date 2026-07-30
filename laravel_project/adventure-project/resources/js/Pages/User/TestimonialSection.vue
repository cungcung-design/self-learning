<script setup>
    const testimonials = [
        {
            name: "Sarah Johnson",
            role: "Avid Hiker",
            text: "Absolutely incredible experience! The guides were knowledgeable and the views were breathtaking. I'll definitely be booking another adventure soon.",
            rating: 5,
        },
        {
            name: "Mike Chen",
            role: "Weekend Explorer",
            text: "The kayaking tour was fantastic. Everything was well-organized, and the equipment was top-notch. Highly recommended for beginners and pros alike.",
            rating: 5,
        },
        {
            name: "Emma Davis",
            role: "Nature Lover",
            text: "I've been on three adventures with this team and each one has been better than the last. Their commitment to eco-friendly tourism is truly commendable.",
            rating: 5,
        },
    ];
</script>

<template>
    <section class="section ">
        <div class="container">
            <h2 class="text-4xl font-extrabold text-center mb-12 text-slate-900 tracking-tight">
                What Our Explorers Say
            </h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    v-for="item in testimonials"
                    :key="item.name"
                    class="bg-white rounded-2xl p-8 border border-stone-100 shadow-sm"
                >
                    <div class="flex gap-1 mb-4">
                        <span v-for="i in 5" :key="i" class="text-lg">
                            {{ i <= item.rating ? '⭐' : '☆' }}
                        </span>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-6 italic">
                        "{{ item.text }}"
                    </p>
                    <div>
                        <p class="font-bold text-slate-800">{{ item.name }}</p>
                        <p class="text-sm text-gray-400">{{ item.role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
