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
                    <td class="px-4 py-2 border">{{ reviewer.reviewer.name }}</td>
                    <td class="px-4 py-2 border">{{ reviewer.request_status }}</td>
                    <td class="px-4 py-2 border">
                        {{ reviewer.complete_reviewed_on ?? 'Not yet reviewed' }}
                    </td>
                    <td class="px-4 py-2 border">{{ reviewer.status }}</td>
                    <td class="px-4 py-2 border">{{formatDate(reviewer.created_at)  }}</td>
                    <td class="px-4 py-2 border text-red-500">
                        <button
                            @click="removeReviewer(reviewer.reviewer.id, index)"
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
                    v-for="reviewer in reviewers"
                    :key="reviewer.id"
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

// Props (replace with actual backend values)
const props = defineProps({
    itemId: Number,
    existingReviewers: Array,
    reviewers: Array,
})

// Reactive Data
const assignedReviewers = ref([...props.existingReviewers])
const selectedReviewer = ref('')
const displayedList = ref('')

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// props.existingReviewers.forEach(item => {
//     if (item.reviewer) {
//         assignedReviewers.value.push(item.reviewer);
//     }
// });

// Methods
function assignReviewer() {

    if (selectedReviewer.value) {
        // Prevent duplicates
        const exists = assignedReviewers.value.find(
            (r) => r.reviewer_id === selectedReviewer.value.id,
        )
            if (!exists) {
                axios.post(`/editor/${selectedReviewer.value.id}/assign-reviewer/${props.itemId}`)
                    .then((res) => {
                        if (res.status === 200) {
                            assignedReviewers.value = res.data
                            selectedReviewer.value = ''

                        }
                    })
            }
    }
}

function removeReviewer(reviewerId, index) {

    console.log(reviewerId, props.itemId)
            assignedReviewers.value.splice(index, 1)
    axios.delete(`/editor/${reviewerId}/assign-reviewer/${props.itemId}`)
        .then(res=>{
        })

}
</script>
