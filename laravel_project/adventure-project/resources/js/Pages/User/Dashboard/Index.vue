<script setup>
import { Link } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/UserDashboardLayout.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
    upcomingAdventure: {
        type: Object,
        default: null,
    },
    recentBookings: {
        type: Array,
        default: () => [],
    },
    recommendedAdventures: {
        type: Array,
        default: () => [],
    },
})

const formatDate = (dateStr) => {
    if (!dateStr) return ''
    const date = new Date(dateStr)
    return date.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
}
</script>

<template>
    <DashboardLayout>
        <div class="dashboard">
            <div class="dashboard-hero">
                <h1 class="dashboard-title">
                    Welcome back, {{ user.name }} 👋
                </h1>
                <p class="dashboard-subtitle">
                    Ready for your next adventure?
                </p>
            </div>

            <div class="dashboard-stats">
                <Link :href="route('user.bookings.index')" class="stat-chip">
                    <span>📅</span>
                    <span>Total Bookings: {{ stats.total_bookings }}</span>
                </Link>

                <div class="stat-chip">
                    <span>🏔</span>
                    <span>Upcoming Trips: {{ stats.upcoming_trips }}</span>
                </div>

                <Link :href="route('user.favorites.index')" class="stat-chip">
                    <span>🤍</span>
                    <span>Favorites: {{ stats.favorites }}</span>
                </Link>

                <div class="stat-chip">
                    <span>⭐</span>
                    <span>Reviews: {{ stats.reviews }}</span>
                </div>
            </div>

            <div class="dashboard-section-header">
                <h2 class="dashboard-section-title">Upcoming Adventure</h2>
                <Link :href="route('user.bookings.index')" class="dashboard-view-all">View All</Link>
            </div>

            <div class="dashboard-main-grid">
                <div v-if="upcomingAdventure" class="upcoming-card">
                    <img
                        :src="upcomingAdventure.image ? '/storage/' + upcomingAdventure.image : 'https://placehold.co/600x400?text=No+Image'"
                        :alt="upcomingAdventure.title"
                    />
                    <div class="upcoming-card-body">
                        <h3 class="upcoming-card-title">🏔 {{ upcomingAdventure.title }}</h3>
                        <div class="upcoming-meta">
                            <span>📍 {{ upcomingAdventure.location }}</span>
                            <span>📅 {{ formatDate(upcomingAdventure.booking_date) }}</span>
                            <span>⏱️ {{ upcomingAdventure.duration }}</span>
                            <span>👥 {{ upcomingAdventure.participants }} People</span>
                        </div>
                        <div class="upcoming-actions">
                            <span class="status-badge">Confirmed</span>
                            <Link :href="route('adventures.show', upcomingAdventure.id)" class="card-btn">View Details</Link>
                        </div>
                    </div>
                </div>

                <div v-else class="upcoming-card flex items-center justify-center" style="min-height: 200px;">
                    <p class="text-gray-500">No upcoming confirmed adventures.</p>
                </div>

                <div class="recent-card">
                    <h3 class="recent-card-title">Recent Bookings</h3>
                    <div v-if="recentBookings.length > 0" class="recent-list">
                        <div v-for="booking in recentBookings" :key="booking.id" class="recent-item">
                            <div class="recent-item-info">
                                <span class="recent-item-icon">🏞</span>
                                <div class="recent-item-text">
                                    <span class="recent-item-name">{{ booking.title }}</span>
                                    <span class="recent-item-location">{{ booking.location }}</span>
                                </div>
                            </div>
                            <div class="recent-item-right">
                                <span class="recent-item-date">{{ formatDate(booking.date) }}</span>
                                <span class="recent-item-status">{{ booking.status }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-sm text-gray-500">
                        No recent bookings yet.
                    </div>
                    <Link :href="route('user.bookings.index')" class="recent-view-all">View All</Link>
                </div>
            </div>

            <div class="dashboard-section-header">
                <h2 class="dashboard-section-title">Recommended For You</h2>
                <Link href="/adventures" class="dashboard-view-all">View All</Link>
            </div>

            <div v-if="recommendedAdventures.length > 0" class="recommended-grid">
                <Link
                    v-for="adventure in recommendedAdventures"
                    :key="adventure.id"
                    :href="route('adventures.show', adventure.id)"
                    class="recommended-card"
                >
                    <img
                        :src="adventure.image ? '/storage/' + adventure.image : 'https://placehold.co/600x400?text=No+Image'"
                        :alt="adventure.title"
                    />
                    <div class="recommended-card-body">
                        <h3 class="recommended-card-title">{{ adventure.title }}</h3>
                        <div class="recommended-card-footer">
                            <span class="recommended-card-price">RM{{ adventure.price }}</span>
                            <span class="recommended-card-rating">⭐ {{ adventure.rating }}</span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </DashboardLayout>
</template>
