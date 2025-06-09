<template>
    <AuthenticatedLayout>
        <div class="p-6 max-w-5xl mx-auto bg-white shadow-xl rounded-xl space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">📊 Track Review</h1>
                <span class="text-sm text-gray-500">Manuscript ID: {{ item.id }}</span>
            </div>

            <!-- Manuscript Info -->
            <div class="bg-gray-50 p-4 rounded-lg border">
                <h2 class="text-lg font-semibold text-gray-700">Manuscript Details</h2>
                <p><strong>Title:</strong> {{ item.title }}</p>
                <p><strong>Author:</strong> {{ item.author.name }}</p>
                <p><strong>Keywords:</strong> {{ item.keywords }}</p>
                <p><strong>Article Type:</strong> {{ item.article_type }}</p>
                <p><strong>Subject Area:</strong> {{ item.subject_area }}</p>
            </div>

            <!-- Reviewers Table -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Assigned Reviewers</h2>
                <table class="min-w-full bg-white border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-left text-sm text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Reviewer</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Submitted Report</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="review in item.reviews" :key="review.id" class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ review.reviewer.name }}</td>
                        <td class="px-4 py-2">
              <span
                  :class="review.status === 'Submitted' ? 'text-green-600' : 'text-yellow-600'"
              >
                {{ review.status }}
              </span>
                        </td>
                        <td class="px-4 py-2">
                            <a
                                v-if="review.report"
                                :href="`/storage/${review.report}`"
                                class="text-blue-600 hover:underline"
                                target="_blank"
                            >
                                View Report
                            </a>
                            <span v-else class="text-gray-400 italic">Pending</span>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button
                                class="bg-yellow-100 text-yellow-800 px-2 py-1 text-xs rounded hover:bg-yellow-200"
                                @click="remindReviewer(review.id)"
                                v-if="review.status !== 'Submitted'"
                            >
                                Remind
                            </button>
                            <button
                                class="bg-red-100 text-red-800 px-2 py-1 text-xs rounded hover:bg-red-200"
                                @click="reassignReviewer(review.id)"
                            >
                                Reassign
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="bg-red-600 w-full h-2">
                <AssignReviewerSection
                    :itemid="item.id"
                    :allReviewers="allReviewers"
                    :existingAssignments="existingAssignments"
                />
            </div>
            <!-- Editor Decision -->
            <div class="pt-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Editor’s Decision</h2>
                <button class="bg-green-200 text-slate-500 px-4 py-2 rounded hover:bg-green-700">
                    Accept
                </button>
                <div class="space-x-2">
                    <button class=" bg-yellow-300 text-slate-500 px-4 py-2 rounded hover:bg-yellow-700">
                        Request Revision
                    </button>
                    <button class="bg-red-600 text-slate-500 px-4 py-2 rounded hover:bg-red-700">
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AssignReviewerSection from "@/Components/AssignReviewerSection.vue";
import {ref} from "vue";

const props = defineProps({
    item: Object,
})

// Dummy methods for interaction
function remindReviewer(id) {
    alert(`Reminder sent to reviewer ${id}`)
}

let manuscriptId = ref(1)

let  allReviewers = ref([
        {id: 1, name: 'Dr. Ade', email: 'ade@example.com'},
        {id: 2, name: 'Prof. Jane', email: 'jane@example.com'}
])

let existingAssignments = ref([
    {id: 1, name: 'Dr. Ade', email: 'ade@example.com'}
]);


function reassignReviewer(id) {
    alert(`Reassigning reviewer ${id}`)
}
</script>
