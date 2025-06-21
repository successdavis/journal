<template>
    <div class="flex items-start gap-6 bg-white shadow-sm rounded-lg overflow-hidden px-4">
        <img :src="journal.image" alt="journal" class="w-32 h-32 object-cover rounded-md" />
        <Link :href="`/browse/journals-and-books/${journal.id}/show`">
            <p class="text-sm text-gray-500 flex items-center gap-1 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c3.314 0 6.315 1.21 8.879 3.204M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ journal.author }}
            </p>
            <h3 class="text-lg font-semibold text-gray-800 leading-snug">{{ journal.title }}</h3>
            <p class="text-gray-600 text-sm mt-1">{{ journal.excerpt }}</p>
        </Link>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
defineProps({
    journal: Object
})
</script>
