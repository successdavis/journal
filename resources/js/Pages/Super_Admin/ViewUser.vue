<template>
    <div class="min-h-screen bg-gray-50 px-6 py-10">
        <div class="max-w-5xl mx-auto bg-white shadow-sm rounded-2xl p-8 space-y-10">
            <!-- Top: Profile + Delete -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-2xl font-bold text-white uppercase">
                        <img
                            v-if="user.profilePhoto"
                            :src="user.profilePhoto"
                            alt="Profile Photo"
                            class="w-full h-full object-cover rounded-full"
                        />
                        <span v-else>{{ initials }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">{{ user.name }}</h1>
                        <p class="text-gray-500 text-sm">{{ user.email }}</p>
                        <p class="text-xs text-gray-400">Joined: {{ formattedDate }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-medium">User Role:</span>
                    <span
                        class="px-2 py-1 text-blue-800 dark:bg-blue-800 dark:text-blue-100 rounded-full text-lg font-bold">
    {{ user.user_role[0].name }}
  </span>
                </div>
                <button
                    @click="deleteUser(user)"
                    class="text-red-500 hover:text-red-600 text-sm border border-red-300 hover:border-red-500 px-3 py-1.5 rounded-lg transition"
                >
                    Delete User
                </button>
            </div>

            <!-- Summary Boxes -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-2xl font-bold text-blue-600">{{ stats.totalPublications }}</p>
                    <p class="text-sm text-gray-600">Publications</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-2xl font-bold text-green-600">{{ stats.totalViews }}</p>
                    <p class="text-sm text-gray-600">Total Views</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-2xl font-bold text-yellow-600">{{ stats.totalDownloads }}</p>
                    <p class="text-sm text-gray-600">Downloads</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-2xl font-bold text-indigo-600">₦{{ stats.totalAmount.toLocaleString() }}</p>
                    <p class="text-sm text-gray-600">Revenue</p>
                </div>
            </div>

            <!-- Recent Publications -->
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Publications</h2>
                <div v-if="user.publications.length > 0" class="space-y-4">
                    <div
                        v-for="publication in user.publications"
                        :key="publication.id"
                        class="p-4 rounded-xl bg-gray-50 border border-gray-200"
                    >
                        <h3 class="text-lg font-medium text-gray-800">
                            {{ publication.title }}
                        </h3>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ publication.excerpt }}</p>
                        <div class="text-xs text-gray-500 mt-2 flex gap-4">
                            <span>Views: {{ publication.views }}</span>
                            <span>Downloads: {{ publication.downloads }}</span>
                            <span>Status: <span class="capitalize">{{ publication.status }}</span></span>
                        </div>
                    </div>
                </div>
                <div v-else class="text-gray-500 text-sm">
                    No publications yet.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['delete'])

const initials = computed(() => {
    const name = props.user.name || ''
    return name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .slice(0, 2)
        .toUpperCase()
})

const formattedDate = computed(() => {
    const date = new Date(props.user.created_at)
    return date.toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    })
})

const stats = computed(() => {
    const publications = props.user.publications || []
    let totalViews = 0
    let totalDownloads = 0
    let totalAmount = 0

    for (const pub of publications) {
        totalViews += pub.views || 0
        totalDownloads += pub.downloads || 0
        totalAmount += parseFloat(pub.amount || 0)
    }

    return {
        totalPublications: publications.length,
        totalViews,
        totalDownloads,
        totalAmount,
    }
})


let deleteUser = (user) => {
    if (confirm(`Are you sure you want to delete the user '${user.name}`)) {
        axios.delete(`/super_admin/user/${user.id}/delete`)
            .then(res => {
                if (res.status === 200) {
                    alert('User deleted successfully!')
                } else {
                    alert('could not delete the user, please try again')
                }
            })
    } else {

    }
}
</script>
