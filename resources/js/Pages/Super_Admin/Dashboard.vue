<script setup>
import Dashboard_cards from "@/Components/Super_Admin/Dashboard_cards.vue";
import {Head, router} from "@inertiajs/vue3";
const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}

</script>


<template>
    <Head title="Super Admin Dashboard" />
    <!-- Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center justify-center">
            <h1 class="text-2xl font-bold text-gray-800"> Super Admin Dashboard</h1>
            </div>

            <button
                @click="logout"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition"
            >
                Logout
            </button>
        </div>
    <hr class="py-3 my-1">


    <Dashboard_cards />


</template>


