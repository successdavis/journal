<template>
    <div class="max-w-7xl mx-auto py-10">
        <!-- Header & Search -->
        <div class="flex justify-between items-center mb-12 flex-col sm:flex-row gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Research Journal Catalogue</h1>
            <input
                v-model="searchQuery"
                @input="fetchJournals"
                type="text"
                placeholder="Search journals..."
                class="border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-orange-500"
            />
        </div>

        <div class="px-4 grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Sidebar Filter -->
            <aside class="md:col-span-1 space-y-6">
                <div v-if="publicationTypes.length">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Publication type</h2>
                    <div
                        v-for="(type, index) in publicationTypes"
                        :key="index"
                        class="flex items-center space-x-2"
                    >
                        <input
                            type="checkbox"
                            :id="`type-${type.title}`"
                            :value="type.title"
                            v-model="filters.types"
                            @change="fetchJournals"
                            class="accent-orange-600 w-4 h-4 rounded"
                        />
                        <label :for="`type-${type.title}`" class="text-sm text-gray-700">{{ type.title }}</label>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Journal status</h2>
                    <div class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            id="accepts-submissions"
                            v-model="filters.acceptsSubmissions"
                            @change="fetchJournals"
                            class="accent-orange-600 w-4 h-4 rounded"
                        />
                        <label for="accepts-submissions" class="text-sm text-gray-700">Accepts submissions</label>
                    </div>
                </div>
            </aside>

            <!-- Journal List -->
            <div class="md:col-span-3">
                <!-- Skeletons -->
                <div v-if="loading" class="space-y-6">
                    <div v-for="i in 3" :key="i" class="animate-pulse bg-white p-4 rounded-lg shadow">
                        <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2 mb-1"></div>
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                    </div>
                </div>

                <!-- Journals -->
                <div v-else-if="journals.length" class="space-y-6">
                    <JournalCard v-for="(journal, index) in journals" :key="index" :journal="journal" />
                </div>

                <div v-else class="text-center text-gray-500">No journals found.</div>

                <!-- Pagination -->
                <div class="flex justify-center mt-10" v-if="pagination.total_pages > 1 && !loading">
                    <Pagination
                        :current-page="pagination.current_page"
                        :total-pages="pagination.total_pages"
                        @page-changed="handlePageChange"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Layout from '@/Layouts/GuestLayout.vue'
import JournalCard from '@/components/JournalCard.vue'
import Pagination from '@/components/Pagination.vue'

defineOptions({ layout: Layout })

const journals = ref([])
const publicationTypes = ref([])
const pagination = ref({
    current_page: 1,
    total_pages: 1,
})
const loading = ref(true)
const searchQuery = ref('')
const filters = ref({
    types: [],
    acceptsSubmissions: false,
})

const fetchJournals = async (page = 1) => {
    loading.value = true

    try {
        const response = await axios.get('/api/publications', {
            params: {
                page,
                search: searchQuery.value,
                types: filters.value.types,
                acceptsSubmissions: filters.value.acceptsSubmissions ? 1 : 0,
            },
        })

        journals.value = response.data.publications.data
        pagination.value = {
            current_page: response.data.publications.current_page,
            total_pages: response.data.publications.last_page,
        }

        if (publicationTypes.value.length === 0 && response.data.types) {
            publicationTypes.value = response.data.types
        }

    } catch (error) {
        console.error('Error fetching journals:', error)
    } finally {
        loading.value = false
    }
}

const handlePageChange = (newPage) => {
    fetchJournals(newPage)
}

// Initial fetch
onMounted(() => fetchJournals())
</script>
