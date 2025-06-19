<template>
        <Navbar />
        <HeroSection />
    <div class="min-h-screen bg-gray-50 text-gray-800 max-w-7xl mx-auto px-4">
        <FeatureSection />
        <LatestItems
            title="Latest Thesis"
            url="api/get-thesis-publications"
        />
        <BookCarousel />
        <UpcomingEvents />
        <FooterSection />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
import HeroSection from '@/Components/HeroSection.vue'
import FeatureSection from '@/Components/FeatureSection.vue'
import FooterSection from '@/Components/FooterSection.vue'
import LatestItems from "@/Components/LatestItems.vue";
import BookCarousel from "@/Components/BookCarousel.vue";
import UpcomingEvents from "@/Components/UpcomingEvents.vue";
</script>
