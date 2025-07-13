<template>
        <div class="max-w-5xl mx-auto p-6 md:p-10 bg-white shadow-xl rounded-3xl space-y-10">
            <!-- Title and Status -->
            <div class="flex justify-between flex-col md:flex-row md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 leading-tight">{{ manuscript.title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">By {{ manuscript.author.name }} (<span class="italic">{{ manuscript.author.email }}</span>)</p>
                </div>
                <div class="text-right space-y-1">
          <span :class="pivotStatusClass" class="px-3 py-1 text-xs font-semibold rounded-full capitalize inline-block">
            {{ manuscript.pivot.request_status }}
          </span>
                    <p class="text-xs text-gray-500">Review Status: <strong>{{ manuscript.pivot.status }}</strong></p>
                </div>
            </div>

            <!-- Abstract -->
            <section>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Abstract</h2>
                <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ manuscript.abstract }}</p>
            </section>

            <!-- Metadata -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-y-3 text-gray-700 text-sm">
                <p><strong>Keywords:</strong> {{ manuscript.keywords }}</p>
                <p><strong>Article Type:</strong> {{ manuscript.article_type }}</p>
                <p><strong>Affiliation:</strong> {{ manuscript.affiliation }}</p>
                <p><strong>Journal:</strong> {{ manuscript.journal }}</p>
                <p><strong>Subject Area:</strong> {{ manuscript.subject_area }}</p>
                <p><strong>Ethical Approval:</strong> {{ manuscript.ethical_approval }}</p>
                <p><strong>Conflict of Interest:</strong> {{ manuscript.conflict_of_interest }}</p>
                <p><strong>Funding Statement:</strong> {{ manuscript.funding_statement }}</p>
            </section>

            <!-- Consent -->
            <section class="text-sm text-gray-700 space-y-1">
                <p><strong>Consent Given:</strong> {{ manuscript.consent ? 'Yes' : 'No' }}</p>
                <p><strong>Originality Confirmed:</strong> {{ manuscript.originality ? 'Yes' : 'No' }}</p>
            </section>

            <!-- Files -->
            <section class="grid md:grid-cols-2 gap-6">
                <!-- Main Document -->
                <div>
                    <h3 class="font-medium text-gray-800 mb-1">Main Document</h3>
                    <a
                        :href="`/${manuscript.main_document}`"
                        target="_blank"
                        class="inline-block text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        View Document
                    </a>
                </div>

                <!-- Cover Letter -->
                <div>
                    <h3 class="font-medium text-gray-800 mb-1">Cover Letter</h3>
                    <a
                        :href="`/storage/${manuscript.cover_letter}`"
                        target="_blank"
                        download
                        class="inline-block text-sm bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition"
                    >
                        Download Cover Letter
                    </a>
                </div>

                <!-- Figures -->
                <div v-if="manuscript.figures.length">
                    <h3 class="font-medium text-gray-800 mb-2">Figures</h3>
                    <div class="flex flex-wrap gap-3">
                        <a
                            v-for="(fig, i) in manuscript.figures"
                            :key="i"
                            :href="`/storage/${fig}`"
                            target="_blank"
                            class="bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-lg hover:bg-gray-300 transition"
                        >
                            Figure {{ i + 1 }}
                        </a>
                    </div>
                </div>

                <!-- Supplementary Files -->
                <div v-if="manuscript.supplementary.length">
                    <h3 class="font-medium text-gray-800 mb-2">Supplementary Files</h3>
                    <div class="flex flex-wrap gap-3">
                        <a
                            v-for="(supp, i) in manuscript.supplementary"
                            :key="i"
                            :href="`/storage/${supp}`"
                            target="_blank"
                            class="bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-lg hover:bg-gray-300 transition"
                        >
                            File {{ i + 1 }}
                        </a>
                    </div>
                </div>
            </section>
        </div>
</template>


<script setup>
import {computed, ref} from 'vue'
import axios from "axios";
import AuthorsSideBar from "@/Components/AuthorsSideBar.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    assignedReview: Object
})

const manuscript = ref([])
    manuscript.value = props.assignedReview.reviewed_manuscripts[0]


const pivotStatusClass = computed(() => {
    switch (manuscript.value.pivot.request_status) {
        case 'accepted':
            return 'bg-green-100 text-green-800'
        case 'pending':
            return 'bg-yellow-100 text-yellow-800'
        case 'rejected':
            return 'bg-red-100 text-red-800'
        default:
            return 'bg-gray-100 text-gray-800'
    }
})
</script>
