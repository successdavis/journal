<template>
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
      <div v-else class="gap-3 grid md:grid-cols-3">
        <PublicationCardTwo
          v-for="(post, index) in publications"
          :key="index"
          :post="post"
        />

      </div>

</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import PublicationCardTwo from './PublicationCardTwo.vue'

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
