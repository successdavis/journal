<template>
    <div class="mb-6">
        <ReviewerDashboardHeader/>
    </div>
    <div class="py-6 w-full lg:max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">📚 Assigned Reviews</h1>

        <div v-if="assignedReviewsTodisplay.length" class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200 rounded-xl shadow-sm bg-white">
                <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Journal</th>
                    <th class="px-4 py-3 text-left">Author</th>
                    <th class="px-4 py-3 text-left">Assigned On</th>
                    <th class="px-4 py-3 text-left">Request Status</th>
                    <th class="px-4 py-3 text-left">Review Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(review, index) in assignedReviewsTodisplay"
                    :key="index"
                    class="border-t text-sm hover:bg-gray-50 transition"
                >
                    <td class="px-4 py-4 font-medium text-teal-900 max-w-xs">
                        {{ review.manuscript.title }}
                    </td>
                    <td class="px-4 py-4">
                        {{ review.manuscript.journal }}
                    </td>
                    <td class="px-4 py-4">
                        {{ review.manuscript.author?.name ?? 'N/A' }}
                    </td>
                    <td class="px-4 py-4">
                        {{ formatDate(review.created_at) }}
                    </td>
                    <td class="px-4 py-4">
              <span
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                  :class="getStatusClass(review.request_status)"
              >
                {{ review.request_status }}
              </span>
                    </td>
                    <td class="px-4 py-4">
              <span
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                  :class="getReviewStatusClass(review.status)"
              >
                {{ review.status }}
              </span>
                    </td>
                    <td class="px-4 py-4 text-center space-y-1 md:space-y-0 md:space-x-2 flex flex-col md:flex-row justify-center items-center">
                        <button
                            v-if="review.request_status === 'pending'"
                            @click="acceptReview(review.reviewer_id, review.manuscript_id)"
                            class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded"
                        >
                            Accept
                        </button>
                        <button
                            v-if="review.request_status === 'pending'"
                            @click="rejectReview(review.reviewer_id, review.manuscript_id)"
                            class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded"
                        >
                            Reject
                        </button>
                        <Link
                            :href="`/super_admin/publication/${review.manuscript.id}/view`"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded"
                        >
                            View
                        </Link>
                        <Link
                            v-if="review.request_status === 'accepted'"
                            :href="`/reviewer/${review.reviewer_id}/submit/${review.manuscript_id}`"
                            class="bg-teal-600 hover:bg-teal-700 text-white text-xs px-3 py-1 rounded"
                        >
                            Submit
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="text-center text-gray-500 mt-20">
            No assigned reviews at the moment.
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from "@inertiajs/vue3"
import axios from "axios"
import ReviewerDashboardHeader from "@/Components/Reviewer/ReviewerDashboardHeader.vue";

const props = defineProps({
    assignedReviews: Array
})

let assignedReviewsTodisplay = ref([...props.assignedReviews])

const acceptReview = (reviewerId, manuscriptId) => {
    axios.patch(`/reviewer/${reviewerId}/accept-review/${manuscriptId}`)
        .then(res => {
            assignedReviewsTodisplay.value = res.data[0]
        })
}

const rejectReview = (reviewerId, manuscriptId) => {
    axios.patch(`/reviewer/${reviewerId}/reject-review/${manuscriptId}`)
        .then(res => {
            assignedReviewsTodisplay.value = res.data[0]
        })
}

const formatDate = (dateStr) => {
    const date = new Date(dateStr)
    return date.toLocaleDateString()
}

const getStatusClass = (status) => {
    return {
        'bg-yellow-200 text-yellow-800': status === 'pending',
        'bg-green-200 text-green-800': status === 'accepted',
        'bg-red-200 text-red-800': status === 'rejected',
    }[status] || 'bg-gray-200 text-gray-800'
}

const getReviewStatusClass = (status) => {
    return {
        'bg-teal-200 text-teal-800': status === 'accepted',
        'bg-blue-200 text-blue-800': status === 'submitted',
        'bg-gray-300 text-gray-800': status === 'pending_acceptance',
        'bg-purple-200 text-purple-800': status === 'completed',
    }[status] || 'bg-gray-100 text-gray-600'
}
</script>
