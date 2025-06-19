<template>
  <div class="flex items-center gap-2">
    <button
      class="px-3 py-1 bg-gray-300 text-sm rounded hover:bg-gray-400"
      :disabled="currentPage === 1"
      @click="$emit('page-changed', currentPage - 1)"
    >
      Previous
    </button>

    <span class="text-sm font-medium text-gray-700">
      Page {{ currentPage }} of {{ totalPages }}
    </span>

    <button
      class="px-3 py-1 bg-gray-300 text-sm rounded hover:bg-gray-400"
      :disabled="currentPage === totalPages"
      @click="$emit('page-changed', currentPage + 1)"
    >
      Next
    </button>
  </div>
</template>

<script setup>
defineProps({
  currentPage: Number,
  totalPages: Number,
})
</script>
