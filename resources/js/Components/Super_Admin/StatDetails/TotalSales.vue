<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Article Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Author's name
                </th>
                <th scope="col" class="px-6 py-3">
                    Total sales
                </th>
                <th scope="col" class="px-6 py-3">
                    Total views
                </th>
                <th scope="col" class="px-6 py-3">
                    Total downloads
                </th>
                <th scope="col" class="px-6 py-3">
                    unit price
                </th>
                <th scope="col" class="px-6 py-3">
                    Total amount
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(item, index) in uniqueReceipts"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-blue-100">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ item.publication.title }}
                </th>
                <td class="px-6 py-4">
                    {{item.publication.author.name}}
                </td>
                <td class="px-6 py-4 text-green-600">
                    {{ counts[item.publication_id] }}
                </td>
                <td class="px-6 py-4 text-green-600">
                    {{ item.publication.views }}
                </td>
                <td
                    class=" py-4 flex items-start justify-start">
                    {{item.publication.downloads}}
                </td>
                <td class="px-6 py-4 text-green-600">
                    {{ item.publication.amount }}
                </td>

                <td class="px-6 py-4 text-green-600">
                    {{amountTotals[item.publication_id] }}
                </td>


            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    data: Array
});

const counts = computed(() => {
    const tempCounts = {};
    props.data.forEach(item => {
        const pubId = item.publication_id;
        if (tempCounts[pubId]) {
            tempCounts[pubId]++;
        } else {
            tempCounts[pubId] = 1;
        }
    });
    return tempCounts;
});

const uniqueReceipts = computed(() => {
    const seen = new Set();
    return props.data.filter(item => {
        if (seen.has(item.publication_id)) return false;
        seen.add(item.publication_id);
        return true;
    });
});

const amountTotals = computed(() => {
    const totals = {};
    props.data.forEach(r => {
        const amt = Number(r.amount);
        if (totals[r.publication_id]) {
            totals[r.publication_id] += amt;
        } else {
            totals[r.publication_id] = amt;
        }
    });
    return totals;
});
</script>


