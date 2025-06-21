<!-- resources/js/Components/Author/SubmissionCardList.vue -->
<template>
  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <div
      v-for="(submission, index) in submissions"
      :key="index"
      class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 p-6 flex flex-col justify-between space-y-4"
    >
      <!-- Title -->
      <h3 class="text-xl font-semibold text-gray-800 line-clamp-2">
        {{ submission.title }}
      </h3>

      <!-- Status Badge -->
      <div class="flex items-center space-x-2">
        <span class="text-sm font-medium text-gray-500">Status:</span>
        <span
          class="text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wide"
          :class="{
            'bg-yellow-100 text-yellow-700': submission.status === 'under review',
            'bg-green-100 text-green-700': submission.status === 'accepted',
            'bg-blue-100 text-blue-700': submission.status === 'published'
          }"
        >
          {{ submission.status }}
        </span>
      </div>

      <!-- Submission Date -->
      <div class="text-sm text-gray-500">
        Submitted on: <span class="font-medium text-gray-700">{{ submission.submitted_at }}</span>
      </div>

      <!-- Action Button (Optional) -->
      <div class="pt-2">
        <button
          class="text-sm text-blue-600 hover:underline font-medium"
          @click="$emit('viewSubmission', submission.id)"
        >
          View Details →
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  submissions: Array
})
defineEmits(['viewSubmission'])
</script>
