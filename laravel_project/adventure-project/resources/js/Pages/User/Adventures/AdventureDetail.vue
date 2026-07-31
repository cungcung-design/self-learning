<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import ReviewForm from '@/Components/Adventure/ReviewForm.vue'
import ReviewSection from '@/Components/Adventure/ReviewSection.vue'
import MapSection from '@/Components/Adventure/MapSection.vue'
import RelatedAdventures from '@/Components/Adventure/RelatedAdventures.vue'

const props = defineProps({
    adventure: Object,
    related: Array,
})

const participants = ref(2)
const selectedScheduleId = ref(null)
const activeImageIndex = ref(0)

const images = computed(() => {
    if (props.adventure.images && props.adventure.images.length > 0) {
        return props.adventure.images
    }
    if (props.adventure.image) {
        return [{ image: props.adventure.image, is_cover: true }]
    }
    return []
})

const availableSchedules = computed(() => {
    if (!props.adventure.schedules) return []
    return props.adventure.schedules.filter(
        (s) => s.status === 'available' && s.capacity - s.booked > 0
    )
})

const totalPrice = computed(() => {
    return props.adventure.price * participants.value
})

function decrement() {
    if (participants.value > 1) participants.value--
}

function increment() {
    if (participants.value < props.adventure.max_people) participants.value++
}

const form = useForm({
    schedule_id: null,
    participants: 2,
})

function bookNow() {
    if (!selectedScheduleId.value) {
        alert('Please select a trip date.')
        return
    }

    form.schedule_id = selectedScheduleId.value
    form.participants = participants.value

    form.post(route('bookings.from-adventure', props.adventure.id), {
        preserveScroll: true,
        onSuccess: () => {
            selectedScheduleId.value = null
            participants.value = 2
        },
    })
}

function setActiveImage(index) {
    activeImageIndex.value = index
}

const getImageUrl = (path) => {
    if (!path) return '';
    if (path.startsWith('http') || path.startsWith('blob:')) return path;
    if (path.startsWith('storage/')) return `/${path}`;
    return `/storage/${path}`;
};
</script>

<template>
    <MainLayout>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            
            <!-- Header Section (Full Width) -->
            <div class="space-y-2 mb-6">
                <nav class="flex text-xs text-gray-500 dark:text-gray-400 space-x-2 font-medium">
                    <Link href="/" class="hover:text-green-600 transition">Home</Link>
                    <span>/</span>
                    <Link href="/adventures" class="hover:text-green-600 transition">Adventures</Link>
                    <span>/</span>
                    <span class="text-gray-900 dark:text-gray-100 truncate max-w-[200px]">{{ adventure.title }}</span>
                </nav>

                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                        {{ adventure.title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-600 dark:text-gray-300 font-medium">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="text-gray-900 dark:text-white font-bold">{{ adventure.rating ?? '4.8' }}</span>
                            <span class="underline cursor-pointer">({{ adventure.reviews?.length ?? 130 }} reviews)</span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center gap-1">
                            <span>📍</span>
                            <span class="underline cursor-pointer">{{ adventure.location }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Layout Split (Left: Gallery & Content | Right: Booking Widget) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Content Area (Gallery + Info) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Compact Gallery Grid (Smaller height, embedded in left column) -->
                    <div class="grid grid-cols-4 gap-2 h-[240px] md:h-[300px] rounded-2xl overflow-hidden group">
                        <!-- Main Image -->
                        <div class="col-span-3 relative h-full w-full bg-gray-200 dark:bg-gray-800">
                            <img
                                v-if="images.length"
                                :src="getImageUrl(images[activeImageIndex]?.image || images[0].image)"
                                :alt="adventure.title"
                                class="w-full h-full object-cover transition duration-300 group-hover:scale-[1.01] cursor-pointer"
                            />
                        </div>
                        <!-- Side Thumbnails -->
                        <div v-if="images.length > 1" class="flex flex-col gap-2 h-full">
                            <div 
                                v-for="(image, index) in images.slice(0, 3)" 
                                :key="image.id || index"
                                @click="setActiveImage(index)"
                                class="relative h-1/3 w-full bg-gray-200 dark:bg-gray-800 overflow-hidden cursor-pointer"
                            >
                                <img
                                    :src="getImageUrl(image.image)"
                                    :alt="adventure.title"
                                    class="w-full h-full object-cover transition duration-300 hover:scale-105"
                                    :class="{ 'brightness-110 ring-2 ring-inset ring-white': activeImageIndex === index, 'brightness-75 hover:brightness-100': activeImageIndex !== index }"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info Badges -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-y border-gray-100 dark:border-gray-800">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-lg">⏱️</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Duration</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ adventure.duration }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-lg">📊</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Difficulty</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ adventure.difficulty || 'Moderate' }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-lg">👥</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Group Size</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Min 2 People</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-lg">🚗</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Transport</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Pickup Included</span>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="space-y-2">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">About this adventure</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ adventure.description || 'Experience the breathtaking view from the top of the mountain. Perfect for nature lovers and adventure seekers looking to escape the city and immerse themselves in the wild.' }}
                        </p>
                    </div>

                    <!-- Map Section -->
                    <div class="space-y-2">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Location</h2>
                        <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm h-48 md:h-64">
                            <MapSection :adventure="adventure" />
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                            <span class="text-yellow-400 text-sm">⭐</span> {{ adventure.rating ?? '4.8' }} 
                            <span class="text-gray-500 text-sm font-normal">({{ adventure.reviews?.length ?? 130 }} reviews)</span>
                        </h2>
                        <ReviewForm v-if="$page.props.auth.user" :adventure-id="adventure.id" />
                        <ReviewSection :reviews="adventure.reviews" />
                    </div>
                </div>

                <!-- Right Sidebar (Sticky Booking Widget) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 flex flex-col gap-5">
                        
                        <!-- Price Header -->
                        <div>
                            <span class="text-2xl font-black text-gray-900 dark:text-white">RM {{ adventure.price }}</span>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> / person</span>
                        </div>

                        <!-- Date Selection -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-wider">Select Date</label>
                            
                            <div v-if="availableSchedules.length > 0" class="grid grid-cols-1 gap-2 max-h-40 overflow-y-auto pr-1">
                                <div
                                    v-for="schedule in availableSchedules"
                                    :key="schedule.id"
                                    @click="schedule.status === 'available' && (selectedScheduleId = schedule.id)"
                                    class="border rounded-xl p-2.5 flex justify-between items-center cursor-pointer transition-all"
                                    :class="{
                                        'border-gray-200 dark:border-gray-700 hover:border-gray-900 dark:hover:border-gray-300': selectedScheduleId !== schedule.id && schedule.status === 'available',
                                        'border-gray-900 dark:border-white bg-gray-50 dark:bg-gray-700 ring-1 ring-gray-900 dark:ring-white': selectedScheduleId === schedule.id,
                                        'opacity-50 cursor-not-allowed bg-gray-50 dark:bg-gray-900': schedule.status !== 'available',
                                    }"
                                >
                                    <div class="font-semibold text-gray-900 dark:text-white text-xs flex items-center gap-1.5">
                                        📅 {{ schedule.trip_date }}
                                    </div>
                                    <div v-if="selectedScheduleId === schedule.id" class="w-3.5 h-3.5 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-white dark:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-800 text-center">
                                No available dates right now.
                            </div>
                        </div>

                        <!-- Participants Selection -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-wider">Participants</label>
                            <div class="flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-xl p-1.5">
                                <button type="button" @click="decrement" :disabled="participants <= 1" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 transition disabled:opacity-30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <span class="font-bold text-sm text-gray-900 dark:text-white">{{ participants }}</span>
                                <button type="button" @click="increment" :disabled="participants >= adventure.max_people" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 transition disabled:opacity-30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Total & Action Buttons -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 space-y-3">
                            <div class="flex justify-between items-center font-bold text-gray-900 dark:text-white text-base">
                                <span>Total Price</span>
                                <span>RM {{ totalPrice }}</span>
                            </div>

                          <button 
                                type="button" 
                                @click="bookNow" 
                                :disabled="!selectedScheduleId || form.processing"
                                class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold text-sm rounded-xl transition disabled:opacity-50 flex items-center justify-center gap-2"
                            >
                                <span v-if="form.processing">Processing...</span>
                                <span v-else>Reserve Now</span>
                            </button>
                            <button type="button" class="w-full py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5">
                                <span>🤍</span> Save to Favorites
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>