<template>
    <AuthenticatedLayout>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                v-for="article in articles"
                :key="article.doi"
                class="bg-white shadow rounded-lg p-4 text-sm"
            >
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Original Research</p>
                <p class="text-xs text-gray-600 mb-2">Accepted on {{ article.date }}</p>

                <h3 class="font-semibold text-gray-900 text-base leading-snug mb-3">
                    {{ article.title }}
                </h3>

                <p class="text-sm text-gray-700 mb-2">
        <span v-for="(author, index) in article.authors" :key="index">
          {{ author }}<span v-if="index !== article.authors.length - 1"> · </span>
        </span>
                </p>

                <p class="text-sm text-gray-500">
                    {{ article.journal }}<br />
                    <a
                        :href="`https://doi.org/${article.doi}`"
                        class="text-blue-600 hover:underline break-all"
                    >
                        doi {{ article.doi }}
                    </a>
                </p>

                <hr class="my-3" />

                <p class="text-sm text-gray-500">
                    <span class="font-semibold">{{ article.views }}</span> views
                </p>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    articles: Object
})




const articles = [
    {
        date: '06 Jun 2025',
        title:
            'High-Dose-Rate Brachytherapy Lowers Travel Burden for Man with Localized Prostate Cancer Compared with External Beam Radiation',
        authors: ['Catherine Liu', 'Hongmei Yang', 'Kevin Bylund', 'Michael Cummings', 'Hong Zhang'],
        journal: 'Frontiers in Urology',
        doi: '10.3389/fruro.2025.1598726',
        views: 373,
    },
    {
        date: '01 Jun 2025',
        title:
            'New Insights in Immunotherapy Targeting Prostate Cancer: Pathways and Delivery Mechanisms',
        authors: ['Anna Belle', 'Isaac Newton', 'Marie Curie'],
        journal: 'Frontiers in Oncology',
        doi: '10.3389/fronc.2025.1598799',
        views: 250,
    },
    {
        date: '28 May 2025',
        title:
            'Comparative Study of Radiotherapy Techniques in Treating Pediatric Tumors with Low Toxicity',
        authors: ['John Smith', 'Elena Gilbert', 'Stefan Salvatore'],
        journal: 'Pediatric Oncology Reports',
        doi: '10.3389/pedor.2025.1598666',
        views: 194,
    },
    {
        date: '20 May 2025',
        title:
            'Nanomedicine for Prostate Cancer: Advances in Drug Delivery Using Nano-Carriers',
        authors: ['Tony Stark', 'Bruce Banner', 'Peter Parker'],
        journal: 'Nano Urology Journal',
        doi: '10.3389/nanoj.2025.1598543',
        views: 423,
    },
]
</script>
