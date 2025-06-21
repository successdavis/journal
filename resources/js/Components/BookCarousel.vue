<template>
    <div class="py-8 relative">
        <!-- Navigation Row -->
        <div class="flex items-center justify-between px-4 mb-4">
            <h2 class="text-lg md:text-xl font-semibold">
                {{ title }}
            </h2>
            <div class="flex items-center space-x-4">
                <button
                    class="w-10 h-10 flex items-center justify-center border rounded-full text-gray-500 hover:text-black"
                    @click="scrollLeft"
                >
                    ‹
                </button>

                <a href="#" class="text-blue-500 hover:underline font-medium text-sm">
                    View All
                </a>

                <button
                    class="w-10 h-10 flex items-center justify-center border rounded-full text-gray-500 hover:text-black"
                    @click="scrollRight"
                >
                    ›
                </button>
            </div>
        </div>

        <!-- Carousel Content -->
        <div class="relative">
            <div
                ref="carousel"
                class="flex space-x-6 overflow-x-auto scroll-smooth px-4 scrollbar-hide"
            >
                <BookCard
                    v-for="(book, index) in books"
                    :key="index"
                    :title="book.title"
                    :image="book.image"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import BookCard from './BookCard.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Book Publications',
    },
    url: {
        type: String,
        required: true,
    },
});

const books = ref([]);
const carousel = ref(null);

const fetchBooks = async () => {
    try {
        const response = await axios.get(props.url);
        books.value = response.data?.books || []; // Adjust if backend returns differently
    } catch (error) {
        console.error('Failed to fetch books:', error);
    }
};

const scrollRight = () => {
    carousel.value.scrollBy({ left: 300, behavior: 'smooth' });
};

const scrollLeft = () => {
    carousel.value.scrollBy({ left: -300, behavior: 'smooth' });
};

onMounted(fetchBooks);
watch(() => props.url, fetchBooks);
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
