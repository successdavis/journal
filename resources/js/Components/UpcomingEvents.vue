<template>
    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
        <!-- Left: Event Cards Carousel -->
        <div class="md:w-2/3 relative">
            <div class="flex gap-4 overflow-hidden">
                <div
                    v-for="(event, index) in visibleEvents"
                    :key="index"
                    class="w-1/2 bg-white rounded shadow relative"
                >
                    <div class="relative">
                        <img :src="event.image" class="h-54 w-full object-cover rounded-t" />
                        <!-- Date Badge -->
                        <div class="absolute top-0 right-3 bg-sky-600 text-white px-2 py-1 text-center">
                            <div class="text-xs font-bold uppercase">{{ event.day }}</div>
                            <div class="text-lg font-semibold">{{ event.date }}</div>
                            <div class="text-lg font-semibold">{{ event.month }}</div>
                        </div>
                    </div>
                    <div class="p-3 text-sm flex justify-between items-center">
                        <span>{{ event.title }}</span>
                        <span class="text-sky-600 text-lg font-bold">+</span>
                    </div>
                </div>
            </div>

            <!-- Pagination Dots -->
            <div class="flex items-center gap-1 mt-3">
        <span
            v-for="(dot, i) in totalPages"
            :key="i"
            class="w-2 h-2 rounded-full"
            :class="i === currentIndex ? 'bg-sky-600' : 'bg-gray-300'"
        ></span>
            </div>

            <!-- Carousel Arrows -->
            <div class="absolute bottom-0 right-0 mt-4 flex gap-2 items-center">
                <button @click="prev" class="text-gray-500 hover:text-sky-600 text-xl">&larr;</button>
                <button @click="next" class="text-gray-500 hover:text-sky-600 text-xl">&rarr;</button>
            </div>
        </div>

        <!-- Right: Title + Description -->
        <div class="md:w-1/3 border-l border-gray-300 pl-6 flex flex-col justify-center">
            <h2 class="text-2xl text-sky-600 font-semibold mb-2">Upcoming Events</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Stay informed about our latest events. Explore, learn, and connect!
            </p>
            <a href="#" class="text-sky-600 text-sm hover:underline flex items-center gap-1">
                SEE ALL <span class="text-base">&rarr;</span>
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
})

const events = ref([])
const loading = ref(true)
const error = ref(null)

const fetchEvents = async () => {
    try {
        const response = await axios.get(props.url)
        events.value = response.data.data || response.data.events || []
    } catch (err) {
        error.value = 'Failed to load events.'
        console.error(err)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchEvents()
})

const currentIndex = ref(0)
const itemsPerPage = 2

const totalPages = computed(() => Math.ceil(events.value.length / itemsPerPage))

const visibleEvents = computed(() =>
    events.value.slice(currentIndex.value, currentIndex.value + itemsPerPage)
)

const next = () => {
    if (currentIndex.value + itemsPerPage < events.value.length) {
        currentIndex.value += itemsPerPage
    }
}

const prev = () => {
    if (currentIndex.value - itemsPerPage >= 0) {
        currentIndex.value -= itemsPerPage
    }
}
</script>
