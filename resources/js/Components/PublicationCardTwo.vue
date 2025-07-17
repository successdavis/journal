<template>
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <img class="rounded-t-lg"  :src="post.image" alt="" />
        </a>
        <div class="p-5">
            <div class="text-sm text-gray-500 flex items-center gap-1 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A3 3 0 015.12 14.2l7.072-7.071a3 3 0 014.243 4.243l-7.072 7.071a3 3 0 01-4.243 0z" />
                </svg>
                {{ post.author }}
            </div>
            <a :href="`/browse/journals-and-books/${post.id}/show`">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ post.title }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ post.excerpt }}</p>
            <Link :href="`/browse/journals-and-books/${post.id}/show`" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                View Full Article
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </Link>
        </div>
    </div>

</template>

<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({
    post: Object
})
</script>
