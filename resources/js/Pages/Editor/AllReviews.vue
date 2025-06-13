<template>
    <AuthenticatedLayout>
            <div class="overflow-x-auto">
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
                    <tr v-for="review in reviews" :key="review.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-blue-700">Round {{ review.round }}</td>
                        <td class="px-4 py-2 capitalize">{{ review.review_manuscript.reviewer.name }}</td>
                        <td class="px-4 py-2">{{ review.review_manuscript.manuscript.title }}</td>
                        <td class="px-4 py-2">{{ review.review_title }}</td>
                        <td class="px-4 py-2 truncate max-w-xs" :title="review.opinion">{{ review.comment_to_editor }}</td>
                        <td class="px-4 py-2">{{ formatDate(review.created_at) }}</td>
                        <td class="px-4 py-2">
                            <a :href="`/${review.annotated_manuscript}`" target="_blank" class="text-blue-600 hover:underline">PDF</a>
                        </td>
                        <td class="px-4 py-2 space-x-2 flex flex-nowrap">
                            <button
                                @click="viewReview(review)"
                                class="px-3 py-1 text-blue-600 text-xs rounded hover:bg-teal-800"
                            >
                               View full <br> Review
                            </button>
                            <button
                                class=" text-green-600 rounded-lg transition"
                            >
                                Accept <br> Review
                            </button>
                            <button
                                class=" text-red-600 rounded-lg transition"
                            >
                                Reject <br> Review
                            </button>
                            <button
                                v-if="review.submit_option === 'draft'"
                                @click="editReview(review)"
                                class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>

</template>



<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
