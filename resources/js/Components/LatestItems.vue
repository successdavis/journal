<template>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-7xl mx-auto px-4 py-10">
    <!-- Sidebar -->
    <aside class="md:col-span-1">
      <h2 class="text-lg font-semibold mb-4">Categories</h2>
      <ul class="space-y-2">
        <template v-if="loading">
          <li v-for="i in 5" :key="'skeleton-cat-' + i" class="h-6 bg-gray-200 rounded animate-pulse"></li>
        </template>
        <template v-else>
          <li
            v-for="(category, index) in categories"
            :key="index"
            @click="() => selectCategory(category)"
            :class="[
              'cursor-pointer p-2 rounded',
              selectedCategory === category
                ? 'bg-blue-600 text-white'
                : 'hover:bg-gray-100'
            ]"
          >
            {{ category }}
          </li>
        </template>
      </ul>
    </aside>

    <!-- Publications -->
    <section class="md:col-span-3 space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">{{ title }}</h2>
        <div class="flex items-center gap-4 text-sm text-blue-600 cursor-pointer">
          <button @click="prevSlide" :disabled="pageIndex === 0" class="disabled:opacity-30">‹</button>
          <span @click="clearCategory" class="hover:underline">View All</span>
          <button @click="nextSlide" :disabled="pageIndex >= totalPages - 1" class="disabled:opacity-30">›</button>
        </div>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="space-y-6">
        <div
          v-for="i in 3"
          :key="'skeleton-pub-' + i"
          class="flex flex-col md:flex-row gap-4 items-start border-b pb-4 animate-pulse"
        >
          <div class="w-full md:w-48 h-32 bg-gray-200 rounded"></div>
          <div class="flex-1 space-y-2">
            <div class="w-1/3 h-4 bg-gray-200 rounded"></div>
            <div class="w-2/3 h-6 bg-gray-300 rounded"></div>
            <div class="w-full h-4 bg-gray-100 rounded"></div>
            <div class="w-28 h-8 bg-gray-300 rounded mt-2"></div>
          </div>
        </div>
      </div>

      <!-- Render Publications -->
      <div v-else class="space-y-6">
        <PublicationCard
          v-for="(post, index) in visiblePosts"
          :key="index"
          :post="post"
        />
        <!-- Pagination Indicator -->
        <div v-if="selectedCategory && totalPages > 1" class="text-sm text-gray-600 text-right pt-2">
          Showing Page {{ pageIndex + 1 }} of {{ totalPages }}
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import PublicationCard from './PublicationCard.vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  url: {
    type: String,
    required: true
  }
})

const categories = ref([])
const publications = ref([])
const selectedCategory = ref('')
const loading = ref(true)
const pageIndex = ref(0)
const itemsPerPage = 3

const fetchData = async () => {
  try {
    const response = await axios.get(props.url)
    categories.value = response.data.categories || []
    publications.value = response.data.publications || []
    selectedCategory.value = categories.value[0] || ''
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)

const filteredPosts = computed(() => {
  if (!selectedCategory.value) return publications.value
  return publications.value.filter(
    post => post.category === selectedCategory.value
  )
})

const visiblePosts = computed(() => {
  const start = pageIndex.value * itemsPerPage
  const end = start + itemsPerPage
  return filteredPosts.value.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(filteredPosts.value.length / itemsPerPage)
})

const nextSlide = () => {
  if (pageIndex.value < totalPages.value - 1) {
    pageIndex.value++
  }
}

const prevSlide = () => {
  if (pageIndex.value > 0) {
    pageIndex.value--
  }
}

const selectCategory = (category) => {
  selectedCategory.value = category
  pageIndex.value = 0
}

const clearCategory = () => {
  selectedCategory.value = ''
  pageIndex.value = 0
}
</script>
