<template>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <!-- Gradient Header -->
        <div class="mb-4 p-4 rounded-md text-gray-600 shadow">
            <h1 class="text-2xl font-bold text-center">{{ publication?.title || 'Untitled Article' }}</h1>
            <p class="text-sm italic text-white/80 text-center">{{ publication?.author.name || 'Unknown Journal' }}</p>
        </div>

        <!-- Stats Summary -->
        <div class="flex items-center justify-center sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-indigo-100 p-4 rounded shadow text-indigo-800">
                <p class="text-sm font-medium">Total Sales</p>
                <p class="text-2xl font-bold">{{ sales.length }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded shadow text-green-800">
                <p class="text-sm font-medium">Total Revenue</p>
                <p class="text-2xl font-bold">
                    {{ formatCurrency(totalRevenue, 'NGN') }}
                </p>
            </div>
            <div class="bg-yellow-100 p-4 rounded shadow text-yellow-800">
                <p class="text-sm font-medium">Total Views</p>
                <p class="text-2xl font-bold">
                    {{ publication?.views ?? '—' }}
                </p>
            </div>

            <div class="bg-indigo-100 p-4 rounded shadow text-yellow-800">
                <p class="text-sm font-medium">Total Downloads</p>
                <p class="text-2xl font-bold">
                    {{ publication?.downloads ?? '—' }}
                </p>
            </div>
        </div>

        <!-- Receipts Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Receipt No</th>
                    <th class="px-6 py-3 text-left font-semibold">Payment Method</th>
                    <th class="px-6 py-3 text-right font-semibold">Amount</th>
                    <th class="px-6 py-3 text-left font-semibold">Purchase Date</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(sale, i) in sales"
                    :key="sale.id"
                    :class="i % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                >
                    <td class="px-6 py-4 font-medium text-gray-900">{{ sale.receipt_no || '—' }}</td>
                    <td class="px-6 py-4 capitalize text-gray-700">{{ sale.payment_method || '—' }}</td>
                    <td class="px-6 py-4 text-right text-green-700 font-semibold">
                        {{ formatCurrency(sale.amount, sale.currency) }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ formatDate(sale.paid_at) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import {computed} from "vue";
// Props
const props = defineProps({
    sales: {
        type: Array,
        required: true
    }
})

// Extract publication
const publication = computed(() => props.sales?.[0]?.publication ?? null)

// Compute total revenue
const totalRevenue = computed(() =>
    props.sales.reduce((sum, s) => sum + parseFloat(s.amount || 0), 0)
)

// Format helpers
function formatCurrency(amount, currency) {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: currency || 'NGN'
    }).format(amount)
}

function formatDate(date) {
    if (!date) return '—'
    return new Date(date).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}
</script>
