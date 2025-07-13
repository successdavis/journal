<template>
    <hr>
    <div class="bg-white my-6 rounded-lg shadow-md space-y-4 py-6">
        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-800">📝 Assign / Reassign Reviewers</h2>
            <table class="min-w-full bg-white border rounded text-sm">
                <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 border">Reviewer Name</th>
                    <th class="px-4 py-2 border">Request Status</th>
                    <th class="px-4 py-2 border">Reviewed On</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Assigned on</th>
                    <th class="px-4 py-2 border">Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(reviewer, index) in assignedReviewers" :key="index" class="border-b">
                    <td class="px-4 py-2 border">{{ reviewer.user.name }}</td>
                    <td class="px-4 py-2 border">{{ reviewer.request_status }}</td>
                    <td class="px-4 py-2 border">
                        {{ reviewer.complete_reviewed_on ?? 'Not yet reviewed' }}
                    </td>
                    <td class="px-4 py-2 border">{{ reviewer.status }}</td>
                    <td class="px-4 py-2 border">{{formatDate(reviewer.created_at)  }}</td>
                    <td class="px-4 py-2 border text-red-500">
                        <button
                            @click="removeReviewer(reviewer, index)"
                            class="text-red-500 text-sm hover:underline"
                        >
                            Remove
                        </button>
                    </td>
                </tr>
                <hr>
                </tbody>
            </table>

        <!-- Assign New Reviewer -->
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Select Reviewer:</label>

            <select
                v-model="selectedReviewer"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-600"
            >
                <option value="" disabled selected>Select a reviewer</option>
                <option
                    v-for="(reviewer, index) in displayedList.users"
                    :key="index"
                    :value="reviewer"
                >
                    {{ reviewer.name }} ({{ reviewer.email }})
                </option>
            </select>

            <button
                @click="assignReviewer"
                class="mt-3 bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700"
                :disabled="!selectedReviewer"
            >
                Assign Reviewer
            </button>
        </div>
    </div>
    <hr>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import axios from "axios";
import indexEsm from "@heroicons/vue";

// Props (replace with actual backend values)
const props = defineProps({
    itemId: Number,
})

// Reactive Data
const assignedReviewers = ref([])
const selectedReviewer = ref('')
const displayedList = ref([])

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Methods
function assignReviewer() {

    console.log(selectedReviewer.value)
    if (selectedReviewer.value) {
        // Prevent duplicates
        const exists = (assignedReviewers.value || []).find(
            (r) => r.reviewer_id === selectedReviewer.value.id
        )
            if (!exists) {
                axios.post(`/admins/${selectedReviewer.value.id}/assign_reviewer/${props.itemId}`)
                    .then((res) => {
                        if (res.status === 200) {
                            assignedReviewers.value = res.data.assignedReviewers
                            displayedList.value = res.data.reviewers
                            selectedReviewer.value = ''
                        }
                    })
            }else {
                alert(selectedReviewer.value.name + ' has already been added to review this article')
            }
    }
}

function fetchReviewers() {
    axios.get(`/dashboard/get_reviewers/${props.itemId}`)
        .then(res=>{
            displayedList.value = res.data.reviewers
            assignedReviewers.value = res.data.assignedReviewers
            console.log(res.data.assignedReviewers)
        })

}


function removeReviewer(reviewer, index) {
    console.log(reviewer)
    axios.delete(`/editor/${reviewer.user.id}/assign_reviewer/${props.itemId}`)
        .then(res=>{
            if (res.status === 200){
            assignedReviewers.value.splice(index, 1)
            }

        })

}



onMounted(()=>{
    fetchReviewers()
})
</script>
