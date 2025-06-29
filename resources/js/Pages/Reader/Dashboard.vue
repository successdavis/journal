<script setup>
import {router} from "@inertiajs/vue3";

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <Head title="Author Dashboard" />
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Reader Dashboard</h1>
                <button
                    @click="logout"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition"
                >
                    Logout
                </button>
            </div>

            <!-- Notifications -->
            <Notifications />
        </div>
    </div>
</template>
