<template>
    <AuthenticatedLayout>
            <ManuscriptsTable
                v-if="articles"
                :items="articles"
            />

            <div v-else>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">You have no submissions Yet</p>
            </div>
    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SearchButton from "@/Components/SearchButton.vue";
import NewManuscript from "@/Pages/Author/NewManuscript.vue";
import ManuscriptsTable from "@/Components/ManuscriptsTable.vue";

defineProps({
    articles: Object
})
</script>
