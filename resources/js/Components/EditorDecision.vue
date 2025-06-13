<template>
    <div class="pt-4 my-6">
        <div class="flex w-full justify-start">
            <div class="w-full max-w-md mx-auto">
                <select id="editorDecision" v-model="review.selectedDecision"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option disabled value="" selected> Make Decision</option>
                    <option value="accept">✅ Accept</option>
                    <option value="minor_revisions">🛠️ Minor Revisions</option>
                    <option value="major_revisions">🧰 Major Revisions</option>
                    <option value="reject">❌ Reject</option>
                    <option value="request_additional_review">🔁 Request Additional Review</option>
                    <option value="resubmit_elsewhere">📦 Resubmit Elsewhere</option>
                    <option value="withdrawn_by_author" disabled class="text-gray-400">🚫 Withdrawn by Author (optional)</option>
                </select>
            </div>

            <button
                v-if="review.submit_option === 'draft'"
                @click="editReview(review)"
                class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700"
            >
                Edit
            </button>
            </div>
    </div>
</template>

<script setup>

    defineProps({
        review: Object
    })
</script>

