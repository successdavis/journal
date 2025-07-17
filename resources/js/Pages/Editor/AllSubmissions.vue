<template>
    <div class="mb-6">
        <EditorsDashboardHeader />
    </div>

    <AllManuscriptsTable
    :items="manuscripts"
    />
</template>

<script setup>
import AllManuscriptsTable from "@/Components/AllManuscriptsTable.vue";
import EditorsDashboardHeader from "@/Components/Editor/EditorsDashboardHeader.vue";


defineProps({
    manuscripts:Array
})
</script>

<style scoped>

</style>
