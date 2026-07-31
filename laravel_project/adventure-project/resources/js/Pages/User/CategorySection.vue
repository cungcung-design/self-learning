<script setup>
// Modern Explore by Category Section
// Compatible with Tailwind CSS and dark mode
</script>

<template>
    <section class=" cat-section py-16 bg-gradient-to-b from-gray-50/50 to-white dark:from-gray-900/50 dark:to-gray-900 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
                <span class="text-xs font-extrabold uppercase tracking-widest text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-3 py-1 rounded-full">
                    Categories
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                    Explore by Category
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Find your preferred style of adventure and dive into unforgettable outdoor activities.
                </p>
            </div>

            <!-- Modern Card Grid with Glow & Glassmorphism effects -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Category Card 1 -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 text-center border border-gray-100 dark:border-gray-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            🏔️
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                            Hiking
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                            Mountain trails &amp; trekking
                        </p>
                    </div>
                </div>

                <!-- Category Card 2 -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 text-center border border-gray-100 dark:border-gray-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            ⛺
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            Camping
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                            Overnight outdoor stays
                        </p>
                    </div>
                </div>

                <!-- Category Card 3 -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 text-center border border-gray-100 dark:border-gray-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            🚣
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Kayaking
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                            River &amp; sea adventures
                        </p>
                    </div>
                </div>

                <!-- Category Card 4 -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 text-center border border-gray-100 dark:border-gray-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 shadow-inner">
                            🧗
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                            Climbing
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                            Rock &amp; wall climbing
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>