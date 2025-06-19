<template>
    <GuestLayout>
        <div class="max-w-7xl mx-auto py-10 px-4">
            <!-- Title & Authors -->
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ journal.title }}</h1>
                <div class="text-sm text-gray-600">
          <span v-for="(author, index) in journal.authors" :key="index">
            <a :href="author.link" class="text-blue-600 hover:underline">{{ author.name }}</a>
            <span v-if="index !== journal.authors.length - 1">, </span>
          </span>
                </div>
                <div class="mt-1 text-sm text-gray-500">
                    Volume {{ journal.volume }}, Issue {{ journal.issue }} ·
                    <a :href="journal.doi" target="_blank" class="text-orange-600 hover:underline">
                        https://doi.org/{{ journal.doi }}
                    </a>
                </div>
            </div>

            <!-- Toolbar Menu -->
            <div class="flex flex-wrap items-center gap-6 border-y py-4 my-6 text-sm text-gray-700">
                <div class="flex items-center gap-1 text-gray-400 cursor-not-allowed">
                    <Bars3Icon class="w-5 h-5" />
                    <span>Contents</span>
                </div>
                <div class="flex items-center gap-1 text-blue-900 font-semibold cursor-pointer">
                    <ArrowDownTrayIcon class="w-5 h-5" />
                    <span>PDF/EPUB</span>
                </div>
                <div class="flex items-center gap-1 text-blue-900 cursor-pointer">
                    <ChatBubbleLeftRightIcon class="w-5 h-5" />
                    <span>Cite article</span>
                </div>
                <div class="flex items-center gap-1 text-blue-900 cursor-pointer">
                    <ShareIcon class="w-5 h-5" />
                    <span>Share options</span>
                </div>
                <div class="flex items-center gap-1 text-blue-900 cursor-pointer">
                    <InformationCircleIcon class="w-5 h-5" />
                    <span>Information, rights and permissions</span>
                </div>
                <div class="flex items-center gap-1 text-blue-900 cursor-pointer">
                    <ChartBarIcon class="w-5 h-5" />
                    <span>Metrics and citations</span>
                </div>
                <div class="flex items-center gap-1 text-gray-400 cursor-not-allowed">
                    <TableCellsIcon class="w-5 h-5" />
                    <span>Figures and tables</span>
                </div>
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
                <div class="md:col-span-3 space-y-6">
                    <div ref="contentRef" class="prose prose-lg max-w-none text-gray-800">
                        <section id="introduction">
                            <h2>Introduction</h2>
                            <p>
                                In our first year as editors of Exceptional Children (EC), we shared our vision to
                                advance equitable educational access...
                            </p>
                        </section>
                        <section id="study-one">
                            <h2>Study One</h2>
                            <p>
                                In the first study, When Being an Expert May Not Be Enough: Understanding the
                                Experiences of Special Education Professionals...
                            </p>
                        </section>
                        <section id="study-two">
                            <h2>Study Two</h2>
                            <p>
                                Elizabeth Bettini, Tuan D. Nguyen, Tammy Ellis-Robinson examine the ethnoracial
                                diversity of U.S. special education...
                            </p>
                        </section>
                        <section id="conclusion">
                            <h2>Conclusion</h2>
                            <p>
                                As we reflect on the work published in this issue, we reiterate our commitment to
                                inclusive educational practices...
                            </p>
                        </section>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <aside class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-3">Similar articles:</h2>
                        <div
                            v-for="(article, index) in journal.similarArticles"
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
    </GuestLayout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const tocItems = ref([])
const activeSection = ref('')
const contentRef = ref(null)

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
    const headings = contentRef.value.querySelectorAll('h2, h3')
    tocItems.value = Array.from(headings).map(h => ({
        id: h.id,
        text: h.innerText,
        level: h.tagName === 'H3' ? 3 : 2
    }))
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})

const journal = {
    title:
        'Deeping the Commitment to Our Editorial Vision and Recognizing Areas for Comprehensive Reform in Special Education',
    authors: [
        { name: 'Endia J. Lindo', link: '#' },
        { name: 'Patricia Martínez-Álvarez', link: '#' },
        { name: 'Kathleen King Thorius', link: '#' }
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
