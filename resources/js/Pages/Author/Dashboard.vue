<script setup>
import { Head, router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import DashboardCards from '@/Components/Author/DashboardCards.vue'
import SubmissionTable from '@/Components/Author/SubmissionTable.vue'
import SubmissionCardList from '@/Components/Author/SubmissionCardList.vue'
import Notifications from '@/Components/Author/Notifications.vue'
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

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <Head title="Author Dashboard" />
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Author Dashboard</h1>
                <a href="/author/submit-new-manuscript" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Submit New Article
                </a>

                <button
                    @click="logout"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition"
                >
                    Logout
                </button>
            </div>

            <!-- Dashboard Cards -->
            <DashboardCards :submissions="submissions" :loading="loading" />

            <!-- Submissions Display -->
            <div v-if="loading">
                <SkeletonTable />
            </div>
            <div v-else>
                <!-- Show Cards on Small Screens -->
                <div class="block md:hidden">
                    <SubmissionCardList :submissions="submissions" />
                </div>
                <!-- Show Table on Medium and Up -->
                <div class="hidden md:block">
                    <SubmissionTable :submissions="submissions" />
                </div>
            </div>

            <!-- Notifications -->
            <Notifications />
        </div>
    </div>
</template>
