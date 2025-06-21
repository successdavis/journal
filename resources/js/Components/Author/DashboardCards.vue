<script setup>
import { DocumentDuplicateIcon, ClockIcon, CheckBadgeIcon, NewspaperIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  submissions: Array,
  loading: Boolean
})

const countByStatus = (status) => {
  return props.submissions.filter(item => item.status === status).length
}
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Submissions -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition group border border-gray-100">
      <div class="flex items-center space-x-4">
        <DocumentDuplicateIcon class="w-10 h-10 text-blue-500 group-hover:scale-110 transition" />
        <div>
          <h2 class="text-sm text-gray-500">Total Submissions</h2>
          <p class="text-2xl font-semibold text-gray-800">{{ loading ? '...' : props.submissions.length }}</p>
        </div>
      </div>
    </div>

    <!-- Under Review -->
    <div class="bg-yellow-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-yellow-200">
      <div class="flex items-center space-x-4">
        <ClockIcon class="w-10 h-10 text-yellow-500 group-hover:scale-110 transition" />
        <div>
          <h2 class="text-sm text-gray-600">Under Review</h2>
          <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('under_review') }}</p>
        </div>
      </div>
    </div>

    <!-- Accepted -->
    <div class="bg-green-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-green-200">
      <div class="flex items-center space-x-4">
        <CheckBadgeIcon class="w-10 h-10 text-green-500 group-hover:scale-110 transition" />
        <div>
          <h2 class="text-sm text-gray-600">Accepted</h2>
          <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('accepted') }}</p>
        </div>
      </div>
    </div>

    <!-- Published -->
    <div class="bg-red-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-red-200">
      <div class="flex items-center space-x-4">
        <NewspaperIcon class="w-10 h-10 text-red-500 group-hover:scale-110 transition" />
        <div>
          <h2 class="text-sm text-gray-600">Published</h2>
          <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('published') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
