<template>
<AuthenticatedLayout>

    <AllManuscriptsTable
    :items="manuscripts"
    />

</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ManuscriptsTable from "@/Components/ManuscriptsTable.vue";
import AllManuscriptsTable from "@/Components/AllManuscriptsTable.vue";


defineProps({
    manuscripts:Array
})
</script>

<style scoped>

</style>
