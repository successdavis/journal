<template>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <!-- Title & Authors -->
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ publication.title }}</h1>
            <div class="text-sm text-gray-600">
          <span>
            <a class="text-blue-600 hover:underline">{{ publication.co_writers }}</a>
              <!--            <span v-if="index !== journal.authors.length - 1">, </span>-->
          </span>
<!--          <span v-for="(author, index) in journal.authors" :key="index">-->
<!--            <a :href="author.link" class="text-blue-600 hover:underline">{{ author.name }}</a>-->
                    <!--            <span v-if="index !== journal.authors.length - 1">, </span>-->
<!--          </span>-->
            </div>
            <div class="mt-1 text-sm text-gray-500">
                {{ publication.citation_information }} ·
                <a :href="journal.doi" target="_blank" class="text-orange-600 hover:underline">
                    <!--                    https://doi.org/{{ journal.doi }}-->
                </a>
            </div>
        </div>

        <!-- Toolbar Menu -->
        <div class="flex flex-wrap items-center gap-6 border-y py-4 my-6 text-sm text-gray-700">
            <!--            <div class="flex items-center gap-1 text-gray-400 cursor-not-allowed">-->
            <!--                <Bars3Icon class="w-5 h-5" />-->
            <!--                <span>Contents</span>-->
            <!--            </div>-->
            <div class="flex items-center gap-1 text-blue-900 font-semibold cursor-pointer" @click="showModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                <span>DOWNLOAD PDF</span>
            </div>
            <div class="flex items-center gap-1 text-blue-900 font-semibold cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                </svg>
                <span>PREMIUM ACCESS</span>
            </div>
            <!--            <div class="flex items-center gap-1 text-blue-900 cursor-pointer">-->
            <!--                <ChatBubbleLeftRightIcon class="w-5 h-5" />-->
            <!--                <span>Cite article</span>-->
            <!--            </div>-->
            <!--            <div class="flex items-center gap-1 text-blue-900 cursor-pointer">-->
            <!--                <ShareIcon class="w-5 h-5" />-->
            <!--                <span>Share options</span>-->
            <!--            </div>-->
            <!--            <div class="flex items-center gap-1 text-blue-900 cursor-pointer">-->
            <!--                <InformationCircleIcon class="w-5 h-5" />-->
            <!--                <span>Information, rights and permissions</span>-->
            <!--            </div>-->
            <!--            <div class="flex items-center gap-1 text-blue-900 cursor-pointer">-->
            <!--                <ChartBarIcon class="w-5 h-5" />-->
            <!--                <span>Metrics and citations</span>-->
            <!--            </div>-->
            <!--            <div class="flex items-center gap-1 text-gray-400 cursor-not-allowed">-->
            <!--                <TableCellsIcon class="w-5 h-5" />-->
            <!--                <span>Figures and tables</span>-->
            <!--            </div>-->
        </div>

        <div class="grid md:grid-cols-5 gap-8">
            <!-- Sidebar: Dynamic Table of Contents -->
            <div class="sticky top-20 space-y-3 hidden md:block">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Table of Contents</h2>
                <ul class="text-sm space-y-2">
                    <li
                        v-for="item in tocItems"
                        :key="item.id"
                        :class="[
                item.level === 3 ? 'ml-4' : '',
                activeSection === item.id ? 'text-orange-600 font-bold' : 'text-blue-700'
              ]"
                    >
                        <a :href="'#' + item.id" class="hover:underline">{{ item.text }}</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="md:col-span-3 space-y-6 relative">
                <div class="relative max-h-60 overflow-hidden">
                    <!-- Abstract Content -->
                    <div ref="contentRef" class="prose prose-lg max-w-none text-gray-800">
                        {{ publication.abstract }}
                    </div>
                    <div v-if="publication.premium">
                        <!-- Fade Overlay -->
                        <div
                            class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>

                        <!-- Read More Button -->
                        <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 z-10">
                            <button
                                @click="showModal = true"
                                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                                Read more
                            </button>
                        </div>
                    </div>

                    <div v-else class="w-full bg-red-600 flex">
                        <!-- Read More Button -->
                        <div
                            class="absolute bottom-4 left-1/2 -translate-x-1/2   z-10 text-center items-center justify-center">
                            <a
                                :href="`/storage/${publication.main_document}`" download
                                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                                Download article
                            </a>
                        </div>
                    </div>

                    <div>
                        <!-- Backdrop -->
                        <div
                            @click="showModal = false"
                            v-show="showModal"
                            class="fixed inset-0 bg-black bg-opacity-80 z-40"
                        ></div>

                        <!-- Modal Content -->
                        <div
                            v-show="showModal"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        >
                            <div
                                class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full sm:w-auto sm:max-w-lg md:max-w-xl transform transition-all"
                                @click.stop
                            >
                                <!-- Close Button -->
                                <button
                                    @click="showModal = false"
                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:hover:text-white"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>

                                <!-- Modal Content Component -->
                                <PublicationPriceModal :publication="publication" />
                            </div>
                        </div>
                    </div>




                </div>
            </div>


            <!-- Right Sidebar -->
            <aside class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Similar articles:</h2>
                    <div
                        v-for="(article, index) in relatedArticles"
                        :key="index"
                        class="border-l-4 pl-3 mb-4"
                        :class="{
                'border-orange-500': article.access === 'open',
                'border-red-500': article.access === 'restricted',
                'border-green-500': article.access === 'free'
              }"
                    >
                        <p class="text-sm text-gray-700 font-semibold">
                            <a href="#" class="hover:underline">{{ article.title }}</a>
                        </p>
                        <p class="text-xs text-gray-500">{{ article.access | capitalize }} access</p>
                    </div>
                </div>

                <div class="border p-4 rounded-md shadow bg-gray-50 text-center">
                    <h3 class="font-semibold text-gray-800 mb-1">Sage Discipline Hubs</h3>
                    <p class="text-sm text-gray-600">Read the latest content</p>
                </div>
            </aside>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, onBeforeUnmount} from 'vue'
import Layout from '@/Layouts/GuestLayout.vue'
import {Link} from "@inertiajs/vue3";
import PublicationPriceModal from "@/Components/PublicationPriceModal.vue";

const tocItems = ref([])
const activeSection = ref('')
const contentRef = ref(null)
const showModal = ref(false)
const relatedArticles = ref([])

let props = defineProps({
    publication: {
        type: Object,
        required: true
    }
})

const handleScroll = () => {
    const headings = contentRef.value.querySelectorAll('h2, h3')
    let closest = null
    let minOffset = Infinity

    headings.forEach(heading => {
        const rect = heading.getBoundingClientRect()
        const offset = Math.abs(rect.top)
        if (offset < minOffset && rect.top < window.innerHeight) {
            minOffset = offset
            closest = heading
        }
    })

    if (closest) {
        activeSection.value = closest.id
    }
}

onMounted(() => {
    fetchSimilarArticles(props.publication.id)
    const headings = contentRef.value.querySelectorAll('h2, h3')
    tocItems.value = Array.from(headings).map(h => ({
        id: h.id,
        text: h.innerText,
        level: h.tagName === 'H3' ? 3 : 2
    }))
    window.addEventListener('scroll', handleScroll, {passive: true})
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})

const journal = {
    title:
        'Deeping the Commitment to Our Editorial Vision and Recognizing Areas for Comprehensive Reform in Special Education',
    authors: [
        {name: 'Endia J. Lindo', link: '#'},
        {name: 'Patricia Martínez-Álvarez', link: '#'},
        {name: 'Kathleen King Thorius', link: '#'}
    ],
    volume: 91,
    issue: 2,
    doi: '10.1177/00144029241302399',
    similarArticles: [
        {
            title:
                'Diversity and Equity in the Distribution of Teachers With Special Education Credentials: Trends From California',
            access: 'open'
        },
        {
            title: 'When Good Intentions Go Awry: A Critical Policy Analysis...',
            access: 'restricted'
        },
        {
            title: 'Introduction to the Special Issue—A Necessary Step in Pursuit of Equity...',
            access: 'free'
        }
    ]
}
const fetchSimilarArticles = (publicationId) => {
    axios.get(`/api/publication/articles-related-to/${publicationId}`)
        .then(res => {
            relatedArticles.value = res.data
            console.log(res.data)
        })

}

defineOptions({
    layout: Layout,
})


</script>

<script>
export default {
    filters: {
        capitalize(value) {
            if (!value) return ''
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }
}

</script>

<style scoped>
html {
    scroll-behavior: smooth;
}

.prose section {
    scroll-margin-top: 100px; /* offset for sticky nav */
}
</style>
