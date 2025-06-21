<script setup>
defineProps({
  submissions: {
    type: Array,
    required: true
  }
})
</script>

<template>
  <div class="bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">My Submissions</h2>

    <div class="overflow-x-auto rounded-lg border border-gray-100">
      <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
          <tr class="text-sm font-medium text-gray-600 uppercase tracking-wider">
            <th class="px-6 py-4 text-left">Title</th>
            <th class="px-6 py-4 text-left">Status</th>
            <th class="px-6 py-4 text-left">Date Submitted</th>
            <th class="px-6 py-4 text-left">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
          <tr
            v-for="(item, index) in submissions"
            :key="index"
            class="hover:bg-gray-50 transition duration-150"
          >
            <td class="px-6 py-4 whitespace-nowrap font-medium">
              {{ item.title }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                :class="{
                  'bg-yellow-100 text-yellow-700': item.status === 'Under Review',
                  'bg-green-100 text-green-700': item.status === 'Accepted',
                  'bg-gray-100 text-gray-600': item.status === 'Draft',
                  'bg-red-100 text-red-600': item.status === 'Rejected',
                  'bg-blue-100 text-blue-700': item.status === 'Published'
                }"
                class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
              >
                {{ item.status }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ item.date }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <a
                :href="`/articles/${index}`"
                class="text-blue-600 hover:underline font-medium text-sm"
              >
                View
              </a>
            </td>
          </tr>

          <tr v-if="submissions.length === 0">
            <td colspan="4" class="px-6 py-6 text-center text-gray-400 italic">
              No submissions found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
