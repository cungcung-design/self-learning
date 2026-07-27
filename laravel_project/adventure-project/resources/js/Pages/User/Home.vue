<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'

import HeroSection from '@/Pages/User/HeroSection.vue'
import StatsSection from '@/Pages/User/StatsSection.vue'
import CategorySection from '@/Pages/User/CategorySection.vue'
import FeaturedSection from '@/Pages/User/FeaturedSection.vue'
import WhyChooseSection from '@/Pages/User/WhyChooseSection.vue'
import TestimonialSection from '@/Pages/User/TestimonialSection.vue'
import CTASection from '@/Pages/User/CTASection.vue'

defineProps({
    adventures: Array,
})
</script>

<template>

<MainLayout>

<HeroSection />

<StatsSection />

<CategorySection />

<FeaturedSection
    :adventures="adventures"
/>

<WhyChooseSection />

<TestimonialSection />

<CTASection />

</MainLayout>

</template>
