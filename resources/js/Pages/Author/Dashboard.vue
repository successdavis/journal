<script setup>
import {Head, router} from '@inertiajs/vue3'
import {onMounted, ref} from 'vue'
import axios from 'axios'
import DashboardCards from '@/Components/Author/DashboardCards.vue'
import SubmissionTable from '@/Components/Author/SubmissionTable.vue'
import SubmissionCardList from '@/Components/Author/SubmissionCardList.vue'
import Notifications from '@/Components/Author/Notifications.vue'
import SkeletonTable from '@/Components/Author/SkeletonTable.vue'
import ResponseNotification from "@/Components/ResponseNotification.vue";
import AuthorDashboardHeader from "@/Components/Author/AuthorDashboardHeader.vue";

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



</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">

        <div class="mb-6">
            <AuthorDashboardHeader/>

        </div>
        <div class="mb-6">
            <!-- Dashboard Cards -->
            <DashboardCards :submissions="submissions" :loading="loading"/>
        </div>

        <!-- Submissions Display -->
        <div v-if="loading">
            <SkeletonTable/>
        </div>
        <div v-else>
            <!-- Show Cards on Small Screens -->
            <div class="block md:hidden">
                <SubmissionCardList :submissions="submissions"/>
            </div>
            <!-- Show Table on Medium and Up -->
            <div class="hidden md:block">
                <SubmissionTable :submissions="submissions"/>
            </div>
        </div>

        <!-- Notifications -->
        <Notifications/>
    </div>
</template>
