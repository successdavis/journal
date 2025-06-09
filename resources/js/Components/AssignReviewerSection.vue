<template>
    <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-800">📝 Assign / Reassign Reviewers</h2>

        <!-- Assigned Reviewers List -->
        <div v-if="assignedReviewers.length" class="space-y-2">
            <p class="text-sm text-gray-600">Currently Assigned:</p>
            <ul class="space-y-1">
                <li
                    v-for="(reviewer, index) in assignedReviewers"
                    :key="index"
                    class="flex justify-between items-center bg-gray-100 px-4 py-2 rounded"
                >
                    <span>{{ reviewer.name }}</span>
                    <button
                        @click="removeReviewer(index)"
                        class="text-red-500 text-sm hover:underline"
                    >
                        Remove
                    </button>
                </li>
            </ul>
        </div>

        <!-- Assign New Reviewer -->
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Select Reviewer:</label>
            <select
                v-model="selectedReviewer"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-600"
            >
                <option value="" disabled>Select a reviewer</option>
                <option
                    v-for="reviewer in allReviewers"
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
</template>

<script setup>
import { ref } from 'vue'

// Props (replace with actual backend values)
const props = defineProps({
    manuscriptId: Number,
    allReviewers: Array,
    existingAssignments: Array
})

// Reactive Data
const assignedReviewers = ref([...props.existingAssignments])
const selectedReviewer = ref(null)

// Methods
function assignReviewer() {
    if (selectedReviewer.value) {
        // Prevent duplicates
        const exists = assignedReviewers.value.find(
            (r) => r.id === selectedReviewer.value.id
        )
        if (!exists) {
            assignedReviewers.value.push(selectedReviewer.value)
            selectedReviewer.value = null
        }
    }
}

function removeReviewer(index) {
    assignedReviewers.value.splice(index, 1)
}
</script>
