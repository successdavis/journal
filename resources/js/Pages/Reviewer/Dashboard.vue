<template>
    <!-- Header -->
    <div class="flex justify-around items-center">
        <h1 class="text-2xl font-bold text-gray-800">Editor Dashboard</h1>
        <ResponseNotification
            :user="$page.props.auth.user"
        />
        <button
            @click="logout"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition"
        >
            Logout
        </button>
    </div>
</template>

<script setup>
import ResponseNotification from "@/Components/ResponseNotification.vue";

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>

<style scoped>

</style>
