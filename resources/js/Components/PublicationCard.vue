<template>
  <div class="flex flex-col md:flex-row gap-4 items-start border-b pb-4">
    <img
      :src="post.image"
      alt="Thumbnail"
      class="w-full md:w-48 h-32 object-cover rounded"
    />
    <div class="flex-1">
      <div class="text-sm text-gray-500 flex items-center gap-1 mb-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A3 3 0 015.12 14.2l7.072-7.071a3 3 0 014.243 4.243l-7.072 7.071a3 3 0 01-4.243 0z" />
        </svg>
        {{ post.author }}
      </div>
      <h3 class="text-lg font-semibold text-gray-800">{{ post.title }}</h3>
      <p class="text-sm text-gray-600 mt-1 mb-3">
        {{ post.excerpt }}
      </p>
      <button class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800 text-sm">
        View Full Article
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  post: Object
})
</script>
