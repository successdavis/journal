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
        <div class="flex">

      <Link :href="`/browse/journals-and-books/${post.id}/show`" class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800 text-sm">
        View Full Article
      </Link>
        <div
            v-show="post.premium"
            class=" p-1 rounded-full">
                <!-- Crown Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="#f58900"
                 class="h-8 w-8 " viewBox="1 1 576 512">
                <path d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6l277.2 0c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"/>
            </svg>
            </div>
        </div>

    </div>
  </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({
  post: Object
})
</script>
