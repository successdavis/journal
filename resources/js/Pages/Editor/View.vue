<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
            <h1 class="text-3xl font-extrabold mb-8 text-gray-800">Submitted Manuscripts</h1>

            <div  :key="item.id"
                class="mb-8 bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200"
            >
                <h2 class="text-2xl font-semibold text-teal-700 mb-2">{{ item.title }}</h2>
                <p class="text-sm text-gray-500 mb-4">by <span
                    class="font-medium text-gray-900">{{ item.author?.name || 'Unknown Author' }}</span></p>

                <p class="mb-3"><span class="font-semibold">Abstract:</span> <span
                    class="text-gray-700">{{ item.abstract }}</span></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4 text-gray-700">
                    <p><span class="font-semibold">Keywords:</span> {{ item.keywords }}</p>
                    <p><span class="font-semibold">Article Type:</span> {{ item.article_type }}</p>
                    <p><span class="font-semibold">Affiliation:</span> {{ item.affiliation }}</p>
                    <p><span class="font-semibold">Journal:</span> {{ item.journal }}</p>
                    <p><span class="font-semibold">Subject Area:</span> {{ item.subject_area }}</p>
                    <p><span class="font-semibold">Ethical Approval:</span> {{ item.ethical_approval }}</p>
                    <p><span class="font-semibold">Conflict of Interest:</span> {{
                            item.conflict_of_interest || 'None'
                        }}</p>
                    <p><span class="font-semibold">Consent Given:</span> <span
                        :class="item.consent ? 'text-green-600' : 'text-red-600'">{{
                            item.consent ? 'Yes' : 'No'
                        }}</span></p>
                    <p><span class="font-semibold">Originality:</span> <span
                        :class="item.originality ? 'text-green-600' : 'text-red-600'">{{
                            item.originality ? 'Yes' : 'No'
                        }}</span></p>
                </div>

                <p class="mb-4"><span class="font-semibold">Funding Statement:</span> {{ item.funding_statement }}</p>

                <p class="mb-3"><span class="font-semibold">Submitted At:</span>
                    {{ new Date(item.created_at).toLocaleString() }}</p>

                <div class="space-y-3">
                    <div>
                        <strong>Main Document:</strong>
                        <a
                            :href="`/storage/${item.main_document}`"
                            target="_blank"
                            class="ml-2 text-teal-600 hover:underline"
                        >
                            View
                        </a>
                    </div>

                    <div>
                        <strong>Figures:</strong>
                        <ul class="list-disc list-inside text-teal-700">
                            <li v-for="(figure, idx) in item.figures" :key="idx">
                                <a :href="`/storage/${figure}`" target="_blank" class="hover:underline">
                                    Figure {{ idx + 1 }} : View
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <strong>Supplementary Files:</strong>
                        <ul class="list-disc list-inside text-teal-700">
                            <li v-for="(file, idx) in item.supplementary" :key="idx">
                                <a :href="`/storage/${file}`" target="_blank" class="hover:underline">
                                    File {{ idx + 1 }} : View
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <strong>Cover Letter:</strong>
                        <a
                            :href="`/storage/${item.cover_letter}`"
                            target="_blank"
                            class="ml-2 text-teal-600 hover:underline"
                        >
                            View
                        </a>
                    </div>
                </div>
                <div class=" w-full ">
                    <AssignReviewerSection
                        :itemId="item.id"
                        :reviewers="props.reviewers"
                        :existingReviewers="props.existingReviewers"
                    />
                </div>

                <div>
                    <EditorDecision />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AssignReviewerSection from "@/Components/AssignReviewerSection.vue";
import {onMounted, ref} from "vue";
import EditorDecision from "@/Components/EditorDecision.vue";



let props = defineProps({
    item: Object,
    reviewers: Array,
    existingReviewers: Array,
})

</script>
