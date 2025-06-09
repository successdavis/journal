<template>
    <div class="w-full relative">
        <input
            v-model="query"
            type="text"
            placeholder="Search by title, abstract, or keywords"
            class="w-full px-4 py-2 border rounded-md shadow-sm border-0 focus:outline-none focus:ring focus:border-0"
        />

        <div v-show="query"  v-if="filteredItems.length" class="absolute top-16 left-0">
                <tr v-for="(item, index) in filteredItems"
                    class=" w-full  bg-yellow-50 border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-left">
                        {{ item.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ item.keywords.length > 10 ? item.keywords.slice(0, 20) + '...' : item.keywords }}
                    </td>
                    <td class="px-6 py-4">
                        {{ item.keywords }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
        </div>
        <p v-show="query"  v-else class="mt-4 text-center text-sm text-gray-500">No results found.</p>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    items: {
        type: Array,
        required: true
    }
})

const query = ref('')

const filteredItems = computed(() => {
    if (!query.value) return props.items

    return props.items.filter(item =>
        [item.title, item.abstract, item.keywords]
            .some(field => field?.toLowerCase().includes(query.value.toLowerCase()))
    )
})
</script>
