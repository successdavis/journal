<script setup>
import {router} from "@inertiajs/vue3";
import {ref} from "vue";
import ResponseNotification from "@/Components/ResponseNotification.vue";

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
                <h1 class="text-2xl font-bold text-gray-800">Reader Dashboard</h1>

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
    </div>
</template>
