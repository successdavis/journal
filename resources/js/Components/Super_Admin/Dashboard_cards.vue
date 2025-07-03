<script setup>
import {Link} from '@inertiajs/vue3';
import {onMounted, ref} from "vue";

const statistics = ref([])


const formatTitle = (key)=> {
    return key
        .replace(/_/g, ' ')         // Replace underscores with spaces
        .replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letters
}

const fetchData = ()=>{
    axios.get('/super_admin/fetch_totals')
        .then(res=>{
            statistics.value = res.data
        })
}

onMounted(()=>{
    fetchData()
})
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-4 ">
        <!-- Card -->
        <div
            v-for="(stat, index) in statistics"
            class="bg-white shadow-md rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">{{ formatTitle(stat.title) }}</p>
                <h2 class="text-2xl font-semibold text-gray-800">{{stat.value}}</h2>
            </div>
            <div
                v-if="stat?.value > 0 && stat?.title"
                class="w-1/4 text-teal-600"
            >
                <Link :href="`/dashboard/${stat.title}/view`">View details</Link>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
