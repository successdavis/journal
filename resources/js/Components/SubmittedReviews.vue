<template>
        <div class="">
            <h1 class="text-2xl font-bold text-gray-800">Submitted Reviews</h1>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-teal-100 text-gray-600 text-left">
                <tr>
                    <th class="px-4 py-3">Round</th>
                    <th class="px-4 py-3">Reviewer</th>
                    <th class="px-4 py-3">Manuscript Title </th>
                    <th class="px-4 py-3">Review Title</th>
                    <th class="px-4 py-3">Comment to editor</th>
                    <th class="px-4 py-3">Submitted On</th>
                    <th class="px-4 py-3">File</th>
                    <th class="px-4 py-3">Actions</th>
                    <th class="px-4 py-3">Editor’s Decision</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                <tr v-for="review in reviews"
                    :key="review.id" class="hover:bg-gray-50">
                    <td class="px-4 py-2 font-medium text-blue-700">Round {{ review.round }}</td>
                    <td class="px-4 py-2 capitalize">{{ review.review_manuscript.reviewer.name }}</td>
                    <td class="px-4 py-2">{{ review.review_manuscript.manuscript.title }}</td>
                    <td class="px-4 py-2">{{ review.review_title }}</td>
                    <td class="px-4 py-2  max-w-xs" >{{review.comment_to_editor}}</td>
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

                    </td>

                    <td
                        v-if="review.review_manuscript.manuscript.status === 'under_review'"
                        class="px-4 py-2 font-medium text-blue-700">
                        <EditorDecision
                        :review="review"
                        :item="item"
                        :reviewers="reviewers"
                        :existingReviewers="existingReviewers"
                        />
                    </td>
                    <td
                        v-else
                        class="px-4 py-2 font-medium text-blue-700">
                        {{ review.review_manuscript.manuscript.status }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

</template>



<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import EditorDecision from "@/Components/EditorDecision.vue";
import AssignReviewerSection from "@/Components/AssignReviewerSection.vue";
let reviews = ref([])

let props = defineProps({
        item: Array,
        reviewers: Array,
        existingReviewers: Array,
})
onMounted(()=>{
axios.get(`/editor/all-reviews/${props.item.id}`)
    .then(res=>{
        reviews.value = res.data

        reviews = reviews.map(review => ({
            ...review,
            selectedDecision: ''
            // disable: ''
        }))
    })
})
function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}
</script>
