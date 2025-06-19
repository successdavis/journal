<template>
  <div class="flex-shrink-0 w-60">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <img
        :src="image"
        :alt="title"
        class="w-full h-80 object-cover"
      />
      <div class="p-4 text-center">
        <h3 class="text-sm font-medium text-gray-700">{{ title }}</h3>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  image: String,
});
</script>
