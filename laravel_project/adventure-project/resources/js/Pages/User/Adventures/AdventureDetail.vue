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
</script>

<template>
    <MainLayout>
        <div class="adventure-detail">
            <!-- Breadcrumb -->
            <nav class="adventure-breadcrumb">
                <Link href="/">Home</Link>
                <span>/</span>
                <Link href="/adventures">Adventures</Link>
                <span>/</span>
                <span>{{ adventure.title }}</span>
            </nav>

            <!-- Main Gallery + Booking Grid -->
            <div class="adventure-grid">
                <!-- Left: Large Image -->
                <div class="adventure-gallery-main">
                    <img
                        v-if="images.length"
                        :src="`/storage/${images[activeImageIndex]?.image || images[0].image}`"
                        :alt="adventure.title"
                    />
                </div>

                <!-- Middle: Thumbnails -->
                <div v-if="images.length > 1" class="adventure-gallery-thumbs">
                    <img
                        v-for="(image, index) in images.slice(0, 3)"
                        :key="image.id || index"
                        :src="`/storage/${image.image}`"
                        :alt="adventure.title"
                        :class="{ active: activeImageIndex === index }"
                        @click="setActiveImage(index)"
                    />
                </div>

                <!-- Right: Booking Card -->
                <div class="booking-sidebar">
                    <div class="booking-price">
                        <strong>RM {{ adventure.price }}</strong> / per person
                    </div>

                    <div class="booking-field">
                        <label>Select Date</label>
                        <div class="space-y-2">
                            <div
                                v-for="schedule in availableSchedules"
                                :key="schedule.id"
                                @click="schedule.status === 'available' && (selectedScheduleId = schedule.id)"
                                class="border rounded-xl p-3 flex justify-between items-center cursor-pointer transition"
                                :class="{
                                    'border-green-600 bg-green-50/30': selectedScheduleId === schedule.id,
                                    'opacity-50 cursor-not-allowed bg-gray-50': schedule.status !== 'available',
                                }"
                            >
                                <div>
                                    <div class="font-bold text-gray-800 text-sm">📅 {{ schedule.trip_date }}</div>
                                </div>
                            </div>
                            <div v-if="availableSchedules.length === 0" class="text-xs text-gray-500">
                                No available schedules.
                            </div>
                        </div>
                    </div>

                    <div class="booking-field">
                        <label>Participants</label>
                        <div class="participants-counter">
                            <button @click="decrement" :disabled="participants <= 1">-</button>
                            <span>{{ participants }}</span>
                            <button @click="increment" :disabled="participants >= adventure.max_people">+</button>
                        </div>
                    </div>

                    <button type="button" class="btn-book" @click="bookNow" :disabled="!selectedScheduleId || form.processing">
                        {{ form.processing ? 'Processing...' : 'Book Now' }}
                    </button>

                    <button class="btn-favorite">
                        <span>🤍</span>
                        <span>Add to Favorites</span>
                    </button>
                </div>
            </div>

            <!-- Title, Location, Rating -->
            <div class="adventure-meta" style="margin-top: 1.5rem;">
                <h1 class="adventure-title">{{ adventure.title }}</h1>
                <div class="adventure-location">📍 {{ adventure.location }}</div>
                <div class="adventure-rating">
                    <span>⭐</span>
                    <strong>{{ adventure.rating ?? '4.8' }}</strong>
                    <span>({{ adventure.reviews?.length ?? 130 }} reviews)</span>
                </div>
            </div>

            <!-- Info Badges -->
            <div class="adventure-badges">
                <span>⏱️ {{ adventure.duration }}</span>
                <span>📊 {{ adventure.difficulty || 'Moderate' }}</span>
                <span>👤 Min 2 People</span>
                <span>🚗 Pickup Included</span>
            </div>

            <!-- About Section -->
            <div class="adventure-about">
                <h2>About this adventure</h2>
                <p>{{ adventure.description || 'Experience the breathtaking view from the top of the mountain. Perfect for nature lovers and adventure seekers.' }}</p>
            </div>

            <!-- Reviews -->
            <div style="margin-top: 3rem;">
                <ReviewForm v-if="$page.props.auth.user" :adventure-id="adventure.id" />
                <ReviewSection :reviews="adventure.reviews" />
            </div>

            <!-- Map -->
            <div style="margin-top: 3rem;">
                <MapSection :adventure="adventure" />
            </div>
        </div>
    </MainLayout>
</template>
