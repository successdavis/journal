<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">User Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ data.length }} registered users</p>
                </div>
                <div class="flex items-center space-x-2">
                    <input
                        type="text"
                        placeholder="Search users..."
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
                        v-model="searchQuery"
                    >
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Contact
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Registered
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr
                    v-for="user in filteredUsers"
                    :key="user.id"
                    class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150"
                >
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                  <span class="text-indigo-600 dark:text-indigo-300 font-medium">
                    {{ user.name.charAt(0) }}
                  </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ user.name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    ID: {{ user.id }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white">{{ user.email }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ user.email_verified_at ? 'Verified email' : 'Unverified email' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
              <span
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  :class="{
                  'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': user.email_verified_at,
                  'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': !user.email_verified_at
                }"
              >
                {{ user.email_verified_at ? 'Active' : 'Pending' }}
              </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ formatDate(user.created_at) }}
                        </div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">
                            {{ formatTimeSince(user.created_at) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <Link
                            :href="`/users/${user.id}`"
                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3"
                        >
                            View
                        </Link>
                        <Link
                            :href="`/users/${user.id}/edit`"
                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                        >
                            Edit
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">{{ filteredUsers.length }}</span> of <span class="font-medium">{{ data.length }}</span> users
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 rounded-md bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                        :disabled="currentPage === 1"
                        @click="currentPage--"
                    >
                        Previous
                    </button>
                    <button
                        class="px-3 py-1 rounded-md bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                        :disabled="currentPage * perPage >= data.length"
                        @click="currentPage++"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        default: () => []
    }
});

const searchQuery = ref('');
const currentPage = ref(1);
const perPage = ref(10);

const filteredUsers = computed(() => {
    let result = props.data;

    // Apply search filter
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter(user => {
            user.name.toLowerCase().includes(query) ||
            user.email.toLowerCase().includes(query)
        })

    }

    // Apply pagination
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;

    return result.slice(start, end);
});

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const formatTimeSince = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    const now = new Date();
    const diffInDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));

    if (diffInDays === 0) return 'Today';
    if (diffInDays === 1) return 'Yesterday';
    if (diffInDays < 7) return `${diffInDays} days ago`;
    if (diffInDays < 30) return `${Math.floor(diffInDays / 7)} weeks ago`;
    return `${Math.floor(diffInDays / 30)} months ago`;
};
</script>
