<template>
    <GuestLayout>
        <HeroSection />
        <div class="min-h-screen bg-gray-50 text-gray-800 max-w-7xl mx-auto">
            <FeatureSection />
            <LatestItems
                title="Latest Thesis"
                url="api/get-thesis-publications"
            />
            <BookCarousel />
            <UpcomingEvents />
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import HeroSection from '@/Components/HeroSection.vue'
import FeatureSection from '@/Components/FeatureSection.vue'
import LatestItems from "@/Components/LatestItems.vue";
import BookCarousel from "@/Components/BookCarousel.vue";
import UpcomingEvents from "@/Components/UpcomingEvents.vue";
</script>
