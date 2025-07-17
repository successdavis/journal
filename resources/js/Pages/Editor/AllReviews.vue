<template>
    <div class="mb-6">
        <EditorsDashboardHeader />
    </div>
    <div class="h-12">

    </div>
            <div class="overflow-x-auto">
                <h1 class="text-2xl font-bold text-gray-800 py-2">All Reviews</h1>

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-teal-400 text-gray-600 text-left">
                    <tr>
                        <th class="px-4 py-3">Round</th>
                        <th class="px-4 py-3">Reviewer</th>
                        <th class="px-4 py-3">Manuscript Title </th>
                        <th class="px-4 py-3">Review Title</th>
                        <th class="px-4 py-3">Comment to editor</th>
                        <th class="px-4 py-3">Submitted On</th>
                        <th class="px-4 py-3">File</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    <tr v-for="review in reviews"
                        :key="review.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-blue-700">Round {{ review.round }}</td>
                        <td class="px-4 py-2 capitalize">{{ review.manuscript.user.name }}</td>
                        <td class="px-4 py-2">{{ review.manuscript.manuscript.title }}</td>
                        <td class="px-4 py-2">{{ review.review_title }}</td>
                        <td class="px-4 py-2 truncate max-w-xs" :title="review.opinion">{{ review.comment_to_editor }}</td>
                        <td class="px-4 py-2">{{ formatDate(review.created_at) }}</td>
                        <td class="px-4 py-2">
                            <a :href="`/storage/${review.annotated_manuscript}`" target="_blank" download="" class="text-blue-600 hover:underline">PDF</a>
                        </td>
                        <td class="px-4 py-2 space-x-2 flex flex-nowrap">
                            <Link
                                :href="`/admin/view_full_review/${review.id}`"
                                class="px-3 py-1 text-blue-600 text-xs rounded hover:bg-teal-800"
                            >
                               View full <br> Review
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
</template>



<script setup>
import EditorsDashboardHeader from "@/Components/Editor/EditorsDashboardHeader.vue";
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    reviews: Array,
    reviewerName: String, // You could pass this from the parent or pull from review.review_manuscript.reviewer.name
})

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function viewReview(review) {
    // Logic to show full review
    console.log('View review:', review.id);
}

function editReview(review) {
    // Logic to edit (if it's a draft)
    console.log('Edit review:', review.id);
}
</script>
