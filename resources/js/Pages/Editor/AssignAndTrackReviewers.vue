<template>
    <AuthenticatedLayout>
        <div class="p-6 max-w-5xl mx-auto bg-white shadow-xl rounded-xl space-y-6 mb-12">
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


            <div class=" w-full ">
                <AssignReviewerSection
                    :itemId="item.id"
                    :reviewers="reviewers"
                    :existingReviewers="existingReviewers"
                />
            </div>

            <!--            SubmittedReview-->
            <div class="h-fit">
                <SubmittedReviews
                :item="item"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AssignReviewerSection from "@/Components/AssignReviewerSection.vue";
import {ref} from "vue";
import EditorDecision from "@/Components/EditorDecision.vue";
import SubmittedReviews from "@/Components/SubmittedReviews.vue";

const props = defineProps({
    item: Object,
    reviewers: Array,
    existingReviewers: Array
})

// Dummy methods for interaction
function remindReviewer(id) {
    alert(`Reminder sent to reviewer ${id}`)
}

let existingAssignments = ref([
    {id: 1, name: 'Dr. Ade', email: 'ade@example.com'}
]);


function reassignReviewer(id) {
    alert(`Reassigning reviewer ${id}`)
}
</script>
