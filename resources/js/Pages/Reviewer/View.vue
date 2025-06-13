<template>
    <AuthenticatedLayout>
    <div class="py-6 w-full lg:max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">📚 Assigned Reviews</h1>

        <div v-if="assignedReviewsTodisplay" class="space-y-4">
            <div
                v-for="(review, index) in assignedReviewsTodisplay.reviewed_manuscripts"
                :key="index"
                class="bg-white rounded-2xl shadow-md border p-5 transition hover:shadow-lg"
            >
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-teal-900">
                            {{ review.title }}
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">
                            Assigned on: {{ formatDate(review.created_at) }}
                        </p>
                        <p class="text-gray-600 text-sm mt-1 mb-6">
                            Abstract: {{review.abstract}}
                        </p>
                        <p class="text-sm mt-1 text-gray-800 bg-gray-300 w-fit px-2 rounded-md">
                            Author: {{ review.author?.name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex flex-col md:items-end space-y-2">
                        <div class="flex gap-3 items-center">
              <span class="px-3 py-1 text-xs font-semibold rounded-full"
                    :class="getStatusClass(review.pivot.request_status)">
                {{ review.pivot.request_status }}
              </span>

                            <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                  :class="getReviewStatusClass(review.pivot.status)">
                {{ review.pivot.status }}
              </span>
                        </div>

                        <div class="flex gap-2 mt-2">
                            <button
                                v-if="review.pivot.request_status === 'pending'"
                                @click="acceptReview(review.pivot.reviewer_id, review.pivot.manuscript_id)"
                                class="px-4 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                Accept
                            </button>

                            <button
                                v-if="review.pivot.request_status === 'pending'"
                                @click="rejectReview(review.pivot.reviewer_id, review.pivot.manuscript_id)"
                                class="px-4 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                Reject
                            </button>


                            <Link
                                :href='`/reviewer/view/${review.id}`'
                                class="px-4 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                View Manuscript
                            </Link>
                            <div class="flex w-full items-center justify-center">
                                <Link
                                    v-if="review.pivot.request_status  === 'accepted'"
                                    :href="`/reviewer/${review.pivot.reviewer_id}/submit/${review.pivot.manuscript_id}`"
                                    class="px-4 py-1 w-32 h-12 text-xs bg-teal-600 text-white flex justify-center items-center rounded hover:bg-teal-700">
                                    Submit Review
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-gray-500 mt-20">
            No assigned reviews at the moment.
        </div>
    </div>
    </AuthenticatedLayout>
</template>


<script setup>
import {onMounted, ref} from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";


let props = defineProps({
    assignedReviews: Array
});

let assignedReviewsTodisplay = ref([])
assignedReviewsTodisplay.value = props.assignedReviews

const acceptReview = (reviewerId, manuscriptId) => {
    axios.patch(`/reviewer/${reviewerId}/accept-review/${manuscriptId}`)
        .then(res=>{
            assignedReviewsTodisplay.value = res.data[0]
        })
}

const rejectReview = (reviewerId, manuscriptId) => {
    axios.patch(`/reviewer/${reviewerId}/reject-review/${manuscriptId}`)
        .then(res=>{
            assignedReviewsTodisplay.value = res.data[0]
        })
}

const viewManuscript = (manuscriptId) => {
    // console.log(manuscriptId)
   axios.get(`/reviewer/view/${manuscriptId}}`)
}

const submitReview = (id) => {
    console.log(`Submit Review for ID: ${id}`)
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
