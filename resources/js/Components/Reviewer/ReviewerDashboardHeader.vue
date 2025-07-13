<template>
    <!-- Header -->
    <Head title="Reviewer Dashboard" />
    <div class="flex justify-around items-center">
        <h1 class="text-2xl font-bold text-gray-800">Reviewer's Dashboard</h1>
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
import {Head} from "@inertiajs/vue3";
import ResponseNotification from "@/Components/ResponseNotification.vue";
import {router} from "@inertiajs/vue3";

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>

<style scoped>

</style>
