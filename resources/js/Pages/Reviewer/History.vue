<template>
    <AuthenticatedLayout>
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-4">My Review History</h2>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-900 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Manuscript Title</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Round</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Submitted On</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                <tr
                    v-for="(review, index) in reviews"
                    :key="review.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-4 py-2 text-sm">{{ index + 1 }}</td>
                    <td class="px-4 py-2 text-sm">{{ review.review_manuscript.manuscript.title }}</td>
                    <td class="px-4 py-2 text-sm">Round {{ review.round }}</td>
                    <td class="px-4 py-2 text-sm">
                        {{ formatDate(review.created_at) }}
                    </td>
                    <td class="px-4 py-2 text-sm capitalize">
              <span
                  :class="[
                  'px-2 py-1 rounded text-xs font-semibold',
                  review.submit_option === 'submitted'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-yellow-100 text-yellow-800'
                ]"
              >
                {{ review.submit_option }}
              </span>
                    </td>
                    <td class="px-4 py-2">
                        <button
                            class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded"
                            @click="viewReview(review.id)"
                        >
                            View
                        </button>

                        <button
                            v-if="review.submit_option !== 'submitted'"
                            class="ml-2 text-sm text-white bg-gray-600 hover:bg-gray-700 px-3 py-1 rounded"
                            @click="editReview(review.id)"
                        >
                            Edit
                        </button>
                        <!-- No delete button -->
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    reviews: Array
})

function viewReview(id) {
    // navigation logic here
    alert(`View review ID: ${id}`)
}

function editReview(id) {
    // logic to edit review if needed
    alert(`Edit review ID: ${id}`)
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateString).toLocaleDateString(undefined, options)
}
</script>
