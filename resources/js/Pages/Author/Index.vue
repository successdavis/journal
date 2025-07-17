<template>
    <!-- Submissions Display -->
    <div v-if="loading">
        <SkeletonTable />
    </div>
    <div v-else>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">My Publications</h2>

            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                    <tr class="text-sm font-medium text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Copies Sold</th>
                        <th class="px-6 py-4 text-left">Date Published</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-left">Action</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                    <tr
                        v-for="(item, index) in submissions"
                        :key="index"
                        class="hover:bg-gray-50 transition duration-150"
                    >
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            {{ item.title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold">
                5
              </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Journal</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a
                                :href="`/articles/${index}`"
                                class="text-blue-600 hover:underline font-medium text-sm"
                            >
                                View
                            </a>
                        </td>
                    </tr>

                    <tr v-if="submissions.length === 0">
                        <td colspan="4" class="px-6 py-6 text-center text-gray-400 italic">
                            No submissions found.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import SubmissionTable from '@/Components/Author/SubmissionTable.vue'
import SkeletonTable from '@/Components/Author/SkeletonTable.vue'

const submissions = ref([])
let loading = ref(true)

onMounted(async () => {
    try {
        loading.value = true
        const res = await axios.get('/api/author/publications')
        submissions.value = res.data.submissions
    } catch (error) {
        console.error('Error fetching submissions:', error)
    } finally {
        loading.value = false
    }
})


const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>
