<template>
    <HeroSection imageSrc="/public/images/bg-image.png" />
    <div class="min-h-screen bg-gray-50 text-gray-800 max-w-7xl mx-auto">
        <FeatureSection />
        <LatestItems
            title="Latest Thesis"
            url="api/get-thesis-publications"
        />
        <BookCarousel
            url="api/get-books-publications"
        />
        <UpcomingEvents url="api/get-events-publications"/>
    </div>
</template>

<script setup>
import { defineOptions } from 'vue'
import Layout from '@/Layouts/GuestLayout.vue'
import HeroSection from '@/Components/HeroSection.vue'
import FeatureSection from '@/Components/FeatureSection.vue'
import LatestItems from "@/Components/LatestItems.vue"
import BookCarousel from "@/Components/BookCarousel.vue"
import UpcomingEvents from "@/Components/UpcomingEvents.vue"

// Set layout with defineOptions (new in Vue 3.3+)
defineOptions({
  layout: Layout,
})
</script>
