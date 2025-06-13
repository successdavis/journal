<template>
    <AuthenticatedLayout>

        <form @submit.prevent class="space-y-8 max-w-4xl mx-auto bg-white px-6 rounded-2xl shadow-lg">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Submit Your Review</h2>

            <!-- Review Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Review Title <span
                    class="text-red-500">*</span></label>
                <input v-model="form.review_title" type="text" required
                       class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"/>
            </div>

            <!-- Opinion -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Opinion <span
                    class="text-red-500">*</span></label>
                <input v-model="form.opinion" type="text" required
                       class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"/>
            </div>

            <!-- General Comment -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">General Comment <span
                    class="text-red-500">*</span></label>
                <textarea v-model="form.general_comment" rows="4" required
                          class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"></textarea>
            </div>

            <!-- Specific Comment -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Specific Comment <span
                    class="text-red-500">*</span></label>
                <textarea v-model="form.specific_comment" rows="4" required
                          class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"></textarea>
            </div>

            <!-- Comment to Editor -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Comment to Editor <span
                    class="text-red-500">*</span></label>
                <textarea v-model="form.comment_to_editor" rows="4" required
                          class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"></textarea>
            </div>

            <!-- Ratings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div v-for="(label, key) in ratings" :key="key">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ label }} <span
                        class="text-red-500">*</span></label>
                    <select v-model="form[key]" required
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600">
                        <option disabled value="">Select rating</option>
                        <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    </select>
                </div>
            </div>

            <!-- Annotated Manuscript Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Annotated Manuscript <span
                    class="text-red-500">*</span></label>
                <input type="file" required @change="handleFileUpload($event, 'annotated_manuscript')"
                       class="w-full text-gray-600"/>
            </div>

            <!-- Supplementary Feedback Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Supplementary Feedback (optional)</label>
                <input type="file" @change="handleFileUpload($event, 'supplementary_feedback')"
                       class="w-full text-gray-600"/>
            </div>

            <!-- Conflict of Interest -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Conflict of Interest <span
                    class="text-red-500">*</span></label>
                <input v-model="form.conflict_of_interest" type="text" required
                       class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600"/>
            </div>

            <!-- Honesty Checkbox -->
            <div>
                <label class="inline-flex items-center text-sm font-medium text-gray-700">
                    This review is honest and unbiased <span class="text-red-500">*</span>
                </label>
                    <input type="checkbox" v-model="form.review_is_honest" required
                           class="rounded border-gray-300 mr-2"/>
            </div>

            <!-- Review Policy Agreement -->
            <div>
                <label class="inline-flex items-center text-sm font-medium text-gray-700">
                    <input v-model="form.agreed_review_policy" type="checkbox" required
                           class="rounded border-gray-300 mr-2"/>
                    I agree to the review policy <span class="text-red-500">*</span>
                </label>
            </div>

            <!-- Submit Option -->
<!--            <div>-->
<!--                <label class="block text-sm font-semibold text-gray-700 mb-1">Submission Option <span-->
<!--                    class="text-red-500">*</span></label>-->
<!--                <select v-model="form.submit_option" required-->
<!--                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-600 focus:border-teal-600">-->
<!--                    <option value="" selected disabled>Select submit option</option>-->
<!--                    <option value="draft">Save as Draft</option>-->
<!--                    <option value="submitted">Submit</option>-->
<!--                </select>-->
<!--            </div>-->

            <!-- Submit Button -->
            <div class="pt-4 w-full flex items-center justify-center ">
                <button type="submit"
                        @click="submitReview(submittingReviewDetails.reviewer_id, submittingReviewDetails.manuscript_id)"
                        class="px-6 py-2 bg-green-500 bg-teal-600 text-white rounded-xl hover:bg-green-400 hover:bg-teal-400">
                    Submit Review
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import {reactive} from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";

const form = reactive({
    review_title: '',
    opinion: '',
    general_comment: '',
    specific_comment: '',
    comment_to_editor: '',
    originality: '',
    clarity_of_writing: '',
    methodology_soundness: '',
    relevance_of_manuscript: '',
    quality_of_data: '',
    annotated_manuscript: null,
    supplementary_feedback: null,
    conflict_of_interest: '',
    review_is_honest: false,
    agreed_review_policy: false,
    submit_option: 'submitted',
})

let props = defineProps({
    submittingReviewDetails: Array,
})
const ratings = {
    originality: 'Originality',
    clarity_of_writing: 'Clarity of Writing',
    methodology_soundness: 'Methodology Soundness',
    relevance_of_manuscript: 'Relevance of Manuscript',
    quality_of_data: 'Quality of Data',
}

function handleFileUpload(event, key) {
    form[key] = event.target.files[0]
}

function submitReview(reviewerId, manuscriptId) {
    const formData = new FormData();

// Add all form fields
    for (const key in form) {
        if (form[key] instanceof File) {
            formData.append(key, form[key]);
        } else {
            formData.append(key, form[key]);
        }
    }

// Add review_manuscript_id from props
    formData.append('review_manuscript_id', props.submittingReviewDetails.id);

// Now send with axios
    axios.post(`/reviewer/${reviewerId}/submit/${manuscriptId}`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(res => {
            alert(res.data.message)
            Object.keys(form).forEach(key => {
                if (typeof form[key] === 'boolean') {
                    form[key] = false;
                } else {
                    form[key] = '';
                }
            });

        })

}
</script>

<style scoped>
form input,
form textarea,
form select {
    @apply border w-full px-3 py-2;
}
</style>
