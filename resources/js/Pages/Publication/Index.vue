<template>

    <div class="max-w-7xl mx-auto py-10">
        <div class="flex justify-between items-center mb-12 flex-col sm:flex-row gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Research Journal Catalogue</h1>
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search journals..."
                class="border border-gray-300 rounded-lg py-2 px-4 w-full sm:w-96 focus:outline-none focus:ring-2 focus:ring-orange-500"
            />
        </div>

        <div class=" px-4 grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Sidebar Filter -->
            <aside class="md:col-span-1 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Publication type</h2>
                    <div v-for="(type, index) in publicationTypes" :key="index" class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            :id="`type-${type.label}`"
                            v-model="filters.types"
                            :value="type.label"
                            class="accent-orange-600 w-4 h-4 rounded"
                        />
                        <label :for="`type-${type.label}`" class="text-sm text-gray-700">{{ type.label }}</label>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Journal status</h2>
                    <div class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            id="accepts-submissions"
                            v-model="filters.acceptsSubmissions"
                            class="accent-orange-600 w-4 h-4 rounded"
                        />
                        <label for="accepts-submissions" class="text-sm text-gray-700">Accepts submissions</label>
                    </div>
                </div>
            </aside>

            <!-- Journal List -->
            <div class="md:col-span-3">


                <div v-if="paginatedJournals.length" class="space-y-6">
                    <JournalCard
                        v-for="(journal, index) in paginatedJournals"
                        :key="index"
                        :journal="journal"
                    />
                </div>
                <div v-else class="text-center text-gray-500">No journals found.</div>

                <div class="flex justify-center mt-10" v-if="totalPages > 1">
                    <Pagination
                        :current-page="currentPage"
                        :total-pages="totalPages"
                        @page-changed="handlePageChange"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import JournalCard from '@/components/JournalCard.vue'
import Pagination from '@/components/Pagination.vue'

const journals = ref([
    {
        author: 'Hillary Farnham',
        title: 'Toward Better-Quality Compounded Drugs — An Update Form',
        excerpt: 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco...',
        image: '/images/journal-1.png',
        type: 'Books',
        acceptsSubmissions: true,
    },
    {
        author: 'Coleman Hoff',
        title: 'Toward Better-Quality Compounded Drugs',
        excerpt: 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco...',
        image: '/images/journal-2.png',
        type: 'Textbooks',
        acceptsSubmissions: false,
    },
    {
        author: 'Frederica Kinnaird',
        title: 'A Milestone For CART Cells & Treatment',
        excerpt: 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco...',
        image: '/images/journal-3.png',
        type: 'Books',
        acceptsSubmissions: true,
    },
    {
        author: 'Frederica Kinnaird',
        title: 'A Milestone For CART Cells & Treatment',
        excerpt: 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco...',
        image: '/images/journal-3.png',
        type: 'Books',
        acceptsSubmissions: true,
    },
    {
        author: 'Frederica Kinnaird',
        title: 'A Milestone For CART Cells & Treatment',
        excerpt: 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco...',
        image: '/images/journal-3.png',
        type: 'Books',
        acceptsSubmissions: true,
    },
])

const publicationTypes = ref([
    { label: 'Journals' },
    { label: 'Books' },
    { label: 'Textbooks' },
    { label: 'Handbooks' },
    { label: 'Reference works' },
    { label: 'Book series' },
])

const filters = ref({
    types: [],
    acceptsSubmissions: false,
})

const searchQuery = ref('')
const currentPage = ref(1)
const pageSize = 3

const filteredJournals = computed(() => {
    return journals.value.filter(journal => {
        const matchesType =
            filters.value.types.length === 0 ||
            filters.value.types.includes(journal.type)

        const matchesStatus = !filters.value.acceptsSubmissions || journal.acceptsSubmissions

        const matchesSearch =
            journal.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            journal.author.toLowerCase().includes(searchQuery.value.toLowerCase())

        return matchesType && matchesStatus && matchesSearch
    })
})

const totalPages = computed(() => Math.ceil(filteredJournals.value.length / pageSize))

const paginatedJournals = computed(() => {
    const start = (currentPage.value - 1) * pageSize
    return filteredJournals.value.slice(start, start + pageSize)
})

const handlePageChange = (newPage) => {
    currentPage.value = newPage
}
</script>

<style scoped>
</style>
