<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Reviewed Articles</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ publications?.length ?? 0 }} publications found</p>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Author
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Journal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Published
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="pub in publications" :key="pub?.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <td class="px-6 py-4 max-w-xs">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ pub?.title ?? 'N/A' }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                            {{ pub?.excerpt ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ pub?.author?.name ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ pub?.affiliation ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ pub?.journal ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ pub?.status === 1 ? 'Published' : 'Unpublished' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ pub?.published_at ? formatDate(pub.published_at) : 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <Link
                            :href="`/super_admin/published_publication/${pub.id}/view`"
                             class="px-3 py-1 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            View
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="publications?.length > 0" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">{{ publications?.length }}</span> of <span class="font-medium">{{ publications?.length }}</span> results
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 rounded-md bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                        disabled
                    >
                        Previous
                    </button>
                    <button
                        class="px-3 py-1 rounded-md bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                        disabled
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    data: {
        type: Array,
        default: () => []
    },
    page_title: String
});

const publications = computed(() => props.data);
let checked = ref(true)

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const formatStatus = (status) => {
    if (!status) return ''
    return status
        .replace(/_/g, ' ')
        .replace(/\b\w/g, c => c.toUpperCase()) // Capitalize each word
}

const ubpublished = (publication)=>{
    if (publication.status === 'published'){
        publication.status = 'accepted';
    }else {
        publication.status = 'published'
    }
        axios.patch(`/super_admin/unpublish_article/${publication.id}`, {publication})
            .then(res=>{
                console.log(publication)
            })
}
</script>
