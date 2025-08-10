<template>
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-6 space-y-8">
            <!-- Header -->
            <div class="flex items-center gap-3 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg">
                <div class="flex-1">
                    <div class="border-b pb-4">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ publication.title }}</h1>
                        <p class="mt-1 text-sm text-gray-500">by {{ publication.author.name }}
                            ({{ publication.affiliation }})</p>
                    </div>
                </div>
            </div>

            <!-- Status + Stats -->
            <div class="flex items-center justify-between flex-wrap gap-4">
        <span
            v-if="publication.status === 1"
            class="bg-green-200 text-green-800 text-xs font-semibold uppercase px-3 py-1 rounded-full"
        >
          Published
        </span>
                <span
                    v-else
                    class="bg-gray-300 text-gray-800 text-xs font-semibold uppercase px-3 py-1 rounded-full"
                >
         Unpublished
        </span>
                <div class="text-sm text-gray-600 dark:text-gray-300 space-x-6">
                    <span>👁️ Views: {{ publication.views }}</span>
                    <span>⬇️ Downloads: {{ publication.downloads }}</span>
                </div>
            </div>
            <hr>
            <div class="flex justify-between">
                <!-- Main Document Download -->
                <div>
                    <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Main Document</h2>
                    <a
                        :href="`/storage/${publication.final_document}`"
                        download
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition"
                    >
                        Download PDF
                    </a>
                </div>
                <!-- Premium Status -->
                <div class="mt-4">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">Access</h2>
                    <div v-if="publication.premium">
    <span class="inline-block bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
      Premium Article – {{ formatCurrency(publication.amount) }}
    </span>
                    </div>
                    <div v-else>
    <span class="inline-block bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
      Free Article
    </span>
                    </div>
                </div>

            </div>
            <hr>

            <!-- Abstract -->
            <div>
                <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Abstract</h2>
                <p class="text-gray-700 dark:text-gray-300">{{ publication.abstract }}</p>
            </div>

            <!-- Keywords -->
            <div>
                <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Keywords</h2>
                <div class="flex flex-wrap gap-2">
          <span
              v-for="word in keywords"
              :key="word"
              class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full"
          >
            {{ word }}
          </span>
                </div>
            </div>


            <!-- Additional Files -->
            <div v-if="supplementary.length || pubFigures.length || publication.cover_letter">
                <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Attachments</h2>
                <ul class="list-disc flex justify-between list-inside text-sm text-gray-700 dark:text-gray-300 space-y-1">

                    <li v-if="publication.cover_letter">
                        <a :href="`/storage/${publication.cover_letter}`" class="text-blue-600 hover:underline"
                           target="_blank">Cover Letter</a>
                    </li>
                    <ul>
                        <li v-for="(fig, index) in pubFigures" :key="fig" class="flex flex-col">
                            <a :href="`/storage/${fig}`" target="_blank" class="text-blue-600 hover:underline">
                                Figure: {{ index + 1 }}
                            </a>
                        </li>
                    </ul>
                    <li v-for="(sup, index) in supplementary" :key="sup">
                        <a :href="`/storage/${sup}`" class="text-blue-600 hover:underline" target="_blank">Supplementary:
                            {{ index + 1 }}</a>
                    </li>
                </ul>
            </div>

            <!-- Ethical, Conflict, Originality, Consent -->
            <div class="grid md:grid-cols-2 gap-6 pt-4 border-t">
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Ethical Approval</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ publication.ethical_approval }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Conflict of Interest</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ publication.conflict_of_interest }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Originality</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ publication.originality ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Consent Provided</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ publication.consent ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AssignReviewerSection from "@/Components/AssignReviewerSection.vue";
import ReviewActionByReviewer from "@/Components/Reviewer/ReviewActionByReviewer.vue";
import {onMounted, ref} from "vue";
import {computed} from "vue";
import EditorDecision from "@/Components/EditorDecision.vue";

const props = defineProps({
    publication: Object
})

// Parse keywords and attachments
const keywords = ref(props.publication.keywords?.split(',') || [])


const pubFigures = computed(() => {
    try {
        const first = JSON.parse(props.publication.figures);
        return typeof first === 'string' ? JSON.parse(first) : first;
    } catch (err) {
        console.error('Invalid figures JSON:', err);
        return [];
    }
});


const supplementary = ref(JSON.parse(props.publication.supplementary || '[]'))

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(amount)
}

</script>
