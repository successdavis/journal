<script setup>
import {router} from "@inertiajs/vue3";
import {ref} from "vue";
import ResponseNotification from "@/Components/ResponseNotification.vue";
import { Link } from '@inertiajs/vue3';


const notifications = ref('');
const notificationCount = ref(0)
const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <Head title="Author Dashboard"/>
        <div class="max-w-7xl mx-auto space-y-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-bold text-gray-800">Welcome</h1>

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
            <hr>

        </div>

        <p class="mt-6">You're login, please return to landing page to purchase any journal of your choice</p>

        <Link class="text-center mt-6 block cursor-pointer bg-blue-800 text-white p-3" href="/">Browse Journals</Link>
    </div>
</template>
