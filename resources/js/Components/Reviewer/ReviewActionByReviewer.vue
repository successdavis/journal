<template>
<!-- Review Action -->
<section class="border-t pt-6">
<div v-if="reviewRequest.request_status === 'pending'">
    <p class="text-gray-700 mb-3 font-medium">Do you accept this review request?</p>
    <div class="flex gap-4">
        <button
            @click="acceptReview(reviewRequest.reviewer_id, reviewRequest.manuscript_id)"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
        >
            Accept
        </button>
        <button
            @click="rejectReview(reviewRequest.reviewer_id, reviewRequest.manuscript_id)"
            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
        >
            Reject
        </button>
    </div>
</div>
<div v-else>
    <p class="text-gray-600 mb-2">You've already <strong>{{ reviewRequest.request_status }}</strong> this review.</p>
    <div class="flex gap-4">
        <button disabled class="bg-gray-300 text-white px-4 py-2 rounded-lg cursor-not-allowed">Accepted</button>
        <button disabled class="bg-gray-300 text-white px-4 py-2 rounded-lg cursor-not-allowed">Reject</button>
    </div>
</div>
<div>
    <div class="flex w-full items-center justify-center">
        <Link
            v-if="reviewRequest.request_status  === 'accepted'"
            :href="`/reviewer/${reviewRequest.reviewer_id}/submit/${reviewRequest.manuscript_id}`"
            class="px-4 py-1 w-32 h-12 text-xs bg-teal-600 text-white flex justify-center items-center rounded hover:bg-teal-700">
            Submit Review
        </Link>
    </div>
</div>
</section>
</template>

<script setup>
import axios from "axios";
import {Link} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
const props = defineProps({
    item: Object,
})

let reviewRequest = ref({})

const fetchReviewDetails = () =>{
    axios.get(`/reviewer/get_review_request/${props.item.id}`)
        .then(res=>{
            reviewRequest.value =  res.data
        });
}

onMounted(()=>{
    fetchReviewDetails()
})

const acceptReview = (reviewerId, manuscriptId) => {
    axios.patch(`/reviewer/${reviewerId}/accept-review/${manuscriptId}`)
        .then(res=>{
            reviewRequest.value = res.data
        })
}
const rejectReview = (reviewerId, manuscriptId) => {

    axios.patch(`/reviewer/${reviewerId}/reject-review/${manuscriptId}`)
        .then(res=>{
            // assignedReviewsTodisplay.value = res.data
            manuscript.value = res.data[1].reviewed_manuscripts[0]
        })
}
const submitReview = (reviewerId, manuscriptId) => {
    axios.post(`/reviewer/${reviewerId}/submit/${manuscriptId}}`)
}


</script>
