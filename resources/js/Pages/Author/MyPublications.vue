<template>
    <div class="mb-6">
        <AuthorDashboardHeader/>

    </div>
    <div>
        <SubmissionTable
        :submissions="publications"
        />
    </div>
</template>

<script setup>
import SubmissionTable from "@/Components/Author/SubmissionTable.vue";
import AuthorDashboardHeader from "@/Components/Author/AuthorDashboardHeader.vue";

defineProps({
    publications: Array
})
</script>

<style scoped>

</style>
