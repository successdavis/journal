<template>
    <div class="bg-white shadow-md rounded-xl p-6 mb-6">
        <h2 class="text-3xl font-bold text-gray-800 border-b pb-2 mb-4">
            Role Request
        </h2>
        <!-- Optional subtext or button can go here -->
        <p class="text-gray-500">Manage or approve new role requests submitted by users.</p>
    </div>
    <RoleRequestTable
        :roleRequests="roleRequests"
    />
</template>

<script setup>
import RoleRequestTable from "@/Components/Super_Admin/RoleRequestTable.vue";

defineProps({
    roleRequests: Array
})
</script>

<style scoped>

</style>
