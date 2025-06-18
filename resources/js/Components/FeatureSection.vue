<template>
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h3 class="text-2xl font-bold text-center mb-12 text-gray-800">Platform Highlights</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <FeatureCard
          v-for="feature in features"
          :key="feature.title"
          :icon="feature.icon"
          :title="feature.title"
          :description="feature.description"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import FeatureCard from './FeatureCard.vue'

const features = [
  {
    icon: '📚',
    title: 'Peer-Reviewed Journals',
    description: 'Access a wide collection of journals reviewed by professionals.',
  },
  {
    icon: '🧑‍🏫',
    title: 'Scholarly Community',
    description: 'Join a network of researchers, educators, and advocates.',
  },
  {
    icon: '📊',
    title: 'Submission & Review',
    description: 'Submit your manuscripts and follow up through a structured review process.',
  },
]
</script>
