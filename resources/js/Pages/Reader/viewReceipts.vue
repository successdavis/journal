<template>
    <div class="bg-white shadow-sm rounded-2xl px-6 py-5 mb-6 flex items-center justify-between border border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Payment Receipts</h1>
            <p class="text-sm text-gray-500">View all your payment history and receipt information.</p>
        </div>

        <div class="flex items-center space-x-3">
<!--            <button class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition">-->
<!--                Download All-->
<!--            </button>-->
            <button class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Filter
            </button>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Article Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Payment Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Receipt No
                </th>
                <th scope="col" class="px-6 py-3">
                    Download
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(receipt, index) in receipts"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ receipt.publication.title }}
                </th>
                <td class="px-6 py-4">
                    {{ receipt.amount }}
                </td>
                <td
                    class="px-6 py-4 font-semibold capitalize"
                    :class="{
                        'text-red-600': receipt.status === 'failed',
                        'text-green-600': receipt.status === 'successful',
                        'text-yellow-600': receipt.status === 'pending',
                        'text-gray-600': !['failed', 'successful', 'pending'].includes(receipt.status),
                      }"
                >
                    {{ receipt.status }}
                </td>
                <td class="px-6 py-4">
                    {{ receipt.receipt_no }}
                </td>
                <td
                    class="px-6 py-4">
                    <Link

                    v-if="receipt.status === 'successful'"
                        :href="`/reader/payment/${receipt.user.id}/${receipt.publication_id}/${receipt.id}`"
                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >Download
                    </Link>
                    <Link
                    v-else
                        :href="`/reader/payment/${receipt.user.id}/${receipt.publication_id}/${receipt.id}`"
                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >Proceed to payment
                    </Link>
                </td>
                <td class="px-6 py-4">
                    <Link :href="`/reader/payment/${receipt.user.id}/${receipt.publication_id}/${receipt.id}`"
                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >view
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    receipts: Array
})
</script>

<style scoped>

</style>
