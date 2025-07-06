<template>
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 border-b pb-2">
            🧾 {{ formatTitle(page_title) }}
        </h1>
    </div>
    <component :is="componentToRender"
    :data="data"
    ></component>
</template>

<script setup>
import TotalSales from "@/Components/Super_Admin/StatDetails/TotalSales.vue";
import TotalReviewers from "@/Components/Super_Admin/StatDetails/TotalReviewers.vue";
import TotalEditors from "@/Components/Super_Admin/StatDetails/TotalEditors.vue";
import PublishedArticles from "@/Components/Super_Admin/StatDetails/PublishedArticles.vue";
import UnderReview from "@/Components/Super_Admin/StatDetails/UnderReview.vue";
import AcceptedArticles from "@/Components/Super_Admin/StatDetails/AcceptedArticles.vue";
import RejectedArticles from "@/Components/Super_Admin/StatDetails/RejectedArticles.vue";
import ArticlesWithdrawnByAuthor from "@/Components/Super_Admin/StatDetails/ArticlesWithdrawnByAuthor.vue";
import TotalAuthors from "@/Components/Super_Admin/StatDetails/TotalAuthors.vue";
import TotalArticles from "@/Components/Super_Admin/StatDetails/TotalArticles.vue";
import TotalUsers from "@/Components/Super_Admin/StatDetails/TotalUsers.vue";


import {computed} from "vue";
const props = defineProps({
    data: Array,
    page_title: String
})

const formatTitle = (key)=> {
    return key
        .replace(/_/g, ' ')         // Replace underscores with spaces
        .replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letters
}

  const componentToRender = computed( () => {
      switch (props.page_title){
          case 'total_sales':
              return TotalSales
          case 'total_users':
              return TotalUsers
          case 'total_articles':
              return TotalArticles
          case 'total_authors':
              return TotalAuthors
          case 'total_reviewers':
              return TotalReviewers ;
          case 'total_editors':
              return TotalEditors ;
          case 'published_articles':
              return PublishedArticles ;
          case 'under_review':
              return UnderReview ;
          case 'accepted_articles':
              return AcceptedArticles ;
          case 'rejected_articles':
              return RejectedArticles ;
          case 'articles_withdrawn_by_authors':
              return ArticlesWithdrawnByAuthor ;
          default: return null;
      }
    })
</script>

<style scoped>

</style>
