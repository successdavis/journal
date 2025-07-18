<template>
    <Head title="Author Dashboard" />

    <div class="max-w-full mx-auto space-y-6">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-gray-800">Author Dashboard</h1>

        <!-- Actions Row -->
        <div class="flex flex-wrap justify-between md:justify-between items-center gap-4">
            <!-- Submit Button -->
            <a
                href="/author/submit-new-manuscript"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                + Submit New Article
            </a>

            <!-- Notification -->
            <div class="flex items-center">
                <ResponseNotification
                    :user="$page.props.auth.user"
                />
            </div>

            <!-- Logout Button -->
            <button
                @click="logout"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition"
            >
                Logout
            </button>
        </div>
    </div>
</template>


<script setup>
import {Head, router} from "@inertiajs/vue3";
import ResponseNotification from "@/Components/ResponseNotification.vue";

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>

<style scoped>

</style>
