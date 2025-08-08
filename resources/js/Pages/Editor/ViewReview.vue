<template>
    <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-2xl mt-10">
        <!-- Header -->
        <div class="border-b pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📄 Review Summary</h1>
            <p class="text-sm text-gray-500 mt-1">Submitted on: {{ formatDate(review.created_at) }}</p>
        </div>

        <!-- Review & Reviewer Info -->
        <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-700">
            <div>
                <p><span class="font-semibold">Reviewer:</span> {{ review.manuscript.user.name }}</p>
                <p><span class="font-semibold">Email:</span> {{ review.manuscript.user.email }}</p>
                <p><span class="font-semibold">Round:</span> {{ review.round }}</p>
                <p><span class="font-semibold">Review Title:</span> {{ review.review_title }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Manuscript Title:</span> {{ review.manuscript.manuscript.title }}</p>
                <p><span class="font-semibold">Journal:</span> {{ review.manuscript.manuscript.journal }}</p>
                <p><span class="font-semibold">Status:</span> {{ review.manuscript.manuscript.status }}</p>
                <p><span class="font-semibold">Author:</span> {{ review.manuscript.manuscript.author.name }}</p>
            </div>
        </div>

        <!-- Review Scores -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📊 Evaluation Scores</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div><strong>Originality:</strong> {{ review.originality }}/5</div>
                <div><strong>Clarity:</strong> {{ review.clarity_of_writing }}/5</div>
                <div><strong>Methodology:</strong> {{ review.methodology_soundness }}/5</div>
                <div><strong>Relevance:</strong> {{ review.relevance_of_manuscript }}/5</div>
                <div><strong>Data Quality:</strong> {{ review.quality_of_data }}/5</div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-10 space-y-6 text-gray-800">
            <div>
                <h2 class="text-xl font-semibold mb-2">📝 General Comment</h2>
                <div v-html="review.general_comment" class="prose max-w-none"></div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2">📌 Specific Comment</h2>
                <div v-html="review.specific_comment" class="prose max-w-none"></div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2">📢 Comment to Editor</h2>
                <div v-html="review.comment_to_editor" class="prose max-w-none"></div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2">⚠️ Conflict of Interest</h2>
                <div v-html="review.conflict_of_interest" class="prose max-w-none"></div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📎 Documents</h2>
            <div class="space-y-2 text-sm">
                <p>
                    <strong>Annotated Manuscript:</strong>
                    <a :href="`/storage/${review.annotated_manuscript}`" target="_blank"
                       class="text-blue-600 underline">
                        View PDF
                    </a>
                </p>
                <p>
                    <strong>Supplementary Feedback:</strong>
                    <a :href="`/storage/${review.supplementary_feedback}`" target="_blank"
                       class="text-blue-600 underline">
                        View PDF
                    </a>
                </p>
            </div>
        </div>

        <!-- Review Policies -->
        <div class="mt-8 text-sm">
            <p><strong>Honest Review:</strong> {{ review.review_is_honest ? 'Yes' : 'No' }}</p>
            <p><strong>Agreed to Policy:</strong> {{ review.agreed_review_policy ? 'Yes' : 'No' }}</p>
            <p><strong>Submission Status:</strong> {{ review.submit_option }}</p>
        </div>


        <!-- If no decision exists and user is an Editor or Super_Admin -->
        <div v-else-if="$page.props.auth.user.role === 'Editor' || $page.props.auth.user.role === 'Super_Admin'" class="bg-white shadow rounded-xl p-6">
            <EditorDecision :review="review" />
        </div>
    </div>
</template>

<script setup>
import EditorDecision from "@/Components/EditorDecision.vue";

const props = defineProps({
    review: Object,
    editorDecision: Object,
})

function formatDate(dateString) {
    const options = {year: 'numeric', month: 'short', day: 'numeric'}
    return new Date(dateString).toLocaleDateString(undefined, options)
}
</script>
