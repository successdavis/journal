<template>
  <div class="p-6 border rounded-lg text-center shadow hover:shadow-md transition">
    <div class="text-5xl mb-4">{{ icon }}</div>
    <h4 class="text-xl font-semibold text-gray-700 mb-2">{{ title }}</h4>
    <p class="text-gray-600">{{ description }}</p>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  description: String,
})
</script>
