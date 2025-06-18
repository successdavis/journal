<template>
    <div class="min-h-screen bg-gray-50 text-gray-800">
        <Navbar />
        <HeroSection />
        <FeatureSection />
        <LatestItems
            title="Latest Thesis"
            url="/api/thesis/latest"
        />
        <FooterSection />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
import HeroSection from '@/Components/HeroSection.vue'
import FeatureSection from '@/Components/FeatureSection.vue'
import FooterSection from '@/Components/FooterSection.vue'
import LatestItems from "@/Components/LatestItems.vue";
</script>
