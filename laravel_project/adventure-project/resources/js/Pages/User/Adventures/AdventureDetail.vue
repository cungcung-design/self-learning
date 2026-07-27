<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import AdventureGallery from '@/Components/Adventure/AdventureGallery.vue'
import AdventureInfo from '@/Components/Adventure/AdventureInfo.vue'
import BookingCard from '@/Components/Booking/BookingCard.vue'
import ReviewForm from '@/Components/Adventure/ReviewForm.vue'
import ReviewSection from '@/Components/Adventure/ReviewSection.vue'
import MapSection from '@/Components/Adventure/MapSection.vue'
import RelatedAdventures from '@/Components/Adventure/RelatedAdventures.vue'

defineProps({
    adventure: Object,
    related: Array,
})
</script>

<template>
    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 px-6">
            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-3 gap-10 items-start">
                
                <!-- Left Column (Gallery, Info, Reviews, Map) -->
                <div class="lg:col-span-2 space-y-10">
                    <AdventureGallery :adventure="adventure" />
                    <AdventureInfo :adventure="adventure" />
                    <ReviewForm v-if="$page.props.auth.user" :adventure-id="adventure.id" />
                    <ReviewSection :reviews="adventure.reviews" />
                    <MapSection :adventure="adventure" />
                </div>

                <!-- Right Column (Sticky Booking Sidebar) -->
                <div class="lg:sticky lg:top-28">
                    <BookingCard :adventure="adventure" />
                </div>

            </div>

            <!-- Related Adventures Section -->
            <div class="mt-20">
                <RelatedAdventures :adventures="related" />
            </div>
        </div>
    </MainLayout>
</template>