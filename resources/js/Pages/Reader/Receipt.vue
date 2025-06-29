<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h2 class="text-2xl font-bold text-center">Payment Receipt</h2>
        </div>

        <div class="p-6 space-y-8">
            <!-- Publication Details -->
            <div>
                <h3 class="text-lg font-semibold mb-2 text-blue-800">📚 Publication Details</h3>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded">
                    <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 w-1/3 bg-gray-100">Title</th>
                        <td class="px-4 py-2">{{ publication.title }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">Description</th>
                        <td class="px-4 py-2">{{ publication.description }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">Amount</th>
                        <td class="px-4 py-2 text-green-600 font-semibold">₦{{ formatAmount(publication.amount) }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">Premium</th>
                        <td class="px-4 py-2">
                <span :class="publication.premium ? 'text-green-600' : 'text-gray-500'">
                  {{ publication.premium ? 'Yes' : 'No' }}
                </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payment Details -->
            <div>
                <h3 class="text-lg font-semibold mb-2 text-blue-800">🧾 Receipt Details</h3>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded">
                    <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 w-1/3 bg-gray-100">Receipt No</th>
                        <td class="px-4 py-2">{{ receipt.receipt_no }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">Reference</th>
                        <td class="px-4 py-2">{{ receipt.reference }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">Status</th>
                        <td class="px-4 py-2">
                <span
                    :class="{
                    'text-green-600': receipt.status === 'successful',
                    'text-yellow-600': receipt.status === 'pending',
                    'text-red-600': receipt.status === 'failed'
                  }"
                    class="font-semibold"
                >
                  {{ capitalize(receipt.status) }}
                </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">Created At</th>
                        <td class="px-4 py-2">{{ formatDate(receipt.created_at) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- User Details -->
            <div>
                <h3 class="text-lg font-semibold mb-2 text-blue-800">👤 User Details</h3>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded">
                    <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 w-1/3 bg-gray-100">Name</th>
                        <td class="px-4 py-2">{{ user.name }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">Email</th>
                        <td class="px-4 py-2">{{ user.email }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Proceed to Paystack Button -->
            <div
                v-show="receipt.status !== 'successful'"
                class="text-center pt-4 border-t">
                <button
                    @click="proceedToPaystack(receipt.id, user.id)"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition"
                >
                    Proceed to Paystack
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";

const props = defineProps({
    publication: Object,
    receipt: Object,
    user: Object,
})

const formatAmount = (val) => {
    return parseFloat(val).toLocaleString('en-NG', {
        style: 'decimal',
        minimumFractionDigits: 2,
    })
}

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleString()
}

const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)

const proceedToPaystack = (receiptId, userId) => {
    // Adjust to your actual route
    axios.post(`/paystack/initiate/${receiptId}/${userId}`)
        .then(res=>{
            // console.log(res.data)
            window.location.href = res.data.url
        })
        .catch(err => {
            console.error('Payment init failed', err)
        })
}
</script>
