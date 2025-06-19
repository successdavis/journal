<template>
    <li class="bg-gray-50 border border-gray-200 rounded-md p-3">
        <div @click="isOpen = !isOpen" class="cursor-pointer">
            <div class="font-semibold text-gray-700 flex justify-between items-center">
                {{ category.name }}
                <svg
                    v-if="category.subcategories && category.subcategories.length"
                    :class="{ 'rotate-180': isOpen }"
                    class="w-4 h-4 transition-transform duration-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="text-sm text-gray-500">Slug: {{ category.slug }}</div>
        </div>

        <!-- Show children recursively -->
        <ul
            v-if="isOpen && category.subcategories && category.subcategories.length"
            class="mt-2 ml-4 space-y-2 text-sm text-gray-600"
        >
            <ExistingCategories
                v-for="(child, idx) in category.subcategories"
                :key="idx"
                :category="child"
            />
        </ul>
    </li>
</template>

<script setup>
import { ref } from 'vue'
import ExistingCategories from "@/Components/ExistingCategories.vue";
const props = defineProps({
    category: Object
})

const isOpen = ref(false)
</script>
