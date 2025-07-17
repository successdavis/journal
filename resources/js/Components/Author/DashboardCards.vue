<script setup>
import { DocumentDuplicateIcon, ClockIcon, CheckBadgeIcon, NewspaperIcon, ShoppingBagIcon, CurrencyDollarIcon } from '@heroicons/vue/24/outline'
import {onMounted, ref} from "vue";

const props = defineProps({
    submissions: Array,
    loading: Boolean
})

const countByStatus = (status) => {
    return props.submissions.filter(item => item.status === status).length
}

const totalSales = ref(0)
const totalEarnings = ref(0)

onMounted(async () => {
    try {
        loading.value = true
        const res = await axios.get('/api/author/publications')
        submissions.value = res.data.submissions

        // Fetch sales & earnings too (mock or from same API)
        totalSales.value = res.data.total_sales || 0
        totalEarnings.value = res.data.total_earnings || 0

    } catch (error) {
        console.error('Error:', error)
    } finally {
        loading.value = false
    }
})

</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Submissions -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition group border border-gray-100">
            <div class="flex items-center space-x-4">
                <DocumentDuplicateIcon class="w-10 h-10 text-blue-500 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm text-gray-500">Total Submissions</h2>
                    <p class="text-2xl font-semibold text-gray-800">{{ loading ? '...' : props.submissions.length }}</p>
                </div>
            </div>
        </div>

        <!-- Under Review -->
        <div class="bg-yellow-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-yellow-200">
            <div class="flex items-center space-x-4">
                <ClockIcon class="w-10 h-10 text-yellow-500 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm text-gray-600">Under Review</h2>
                    <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('under_review') }}</p>
                </div>
            </div>
        </div>

        <!-- Accepted -->
        <div class="bg-green-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-green-200">
            <div class="flex items-center space-x-4">
                <CheckBadgeIcon class="w-10 h-10 text-green-500 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm text-gray-600">Accepted</h2>
                    <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('accepted') }}</p>
                </div>
            </div>
        </div>

        <!-- Published -->
        <div class="bg-red-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-red-200">
            <div class="flex items-center space-x-4">
                <NewspaperIcon class="w-10 h-10 text-red-500 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm text-gray-600">Published</h2>
                    <p class="text-2xl font-semibold text-gray-900">{{ loading ? '...' : countByStatus('published') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- New Sales & Earnings Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-6">

        <!-- Total Sales Card -->
        <div class="bg-purple-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-purple-200">
            <div class="flex items-center space-x-4">
                <ShoppingBagIcon class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm font-medium text-gray-600 tracking-wide uppercase">Total Sales</h2>
                    <p class="text-3xl font-bold text-gray-900">{{ loading ? '...' : totalSales }}</p>
                </div>
            </div>
        </div>

        <!-- Earnings Card -->
        <div class="bg-indigo-50 p-6 rounded-2xl shadow hover:shadow-lg transition group border border-indigo-200">
            <div class="flex items-center space-x-4">
                <CurrencyDollarIcon class="w-10 h-10 text-indigo-600 group-hover:scale-110 transition" />
                <div>
                    <h2 class="text-sm font-medium text-gray-600 tracking-wide uppercase">My Earnings</h2>
                    <p class="text-3xl font-bold text-gray-900">{{ loading ? '...' : `₦${totalEarnings}` }}</p>
                </div>
            </div>
        </div>

    </div>
</template>
