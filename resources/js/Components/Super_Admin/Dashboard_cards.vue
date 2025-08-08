<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from "vue";

const statistics = ref([]);
const isLoading = ref(true);

const formatTitle = (key) => {
    return key
        .replace(/_/g, ' ')
        .replace(/\b\w/g, char => char.toUpperCase());
}

const fetchData = () => {
    axios.get('/super_admin/fetch_totals')
        .then(res => {
            statistics.value = res.data;
        })
        .finally(() => {
            setTimeout(() => isLoading.value = false, 300); // Smooth loading transition
        });
}

onMounted(() => {
    fetchData();
});

// Card color variants
const cardVariants = {
    default: 'from-indigo-500 to-indigo-600',
    success: 'from-emerald-500 to-teal-600',
    warning: 'from-amber-500 to-orange-500',
    danger: 'from-rose-500 to-pink-600'
};

const getCardVariant = (title) => {
    const lowerTitle = title.toLowerCase();
    if (lowerTitle.includes('pending')) return 'warning';
    if (lowerTitle.includes('rejected')) return 'danger';
    if (lowerTitle.includes('approved')) return 'success';
    return 'default';
};
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 px-1 py-3">
        <!-- Skeleton Loader -->
        <template v-if="isLoading">
            <div
                v-for="i in 4"
                :key="`skeleton-${i}`"
                class="h-32 bg-white rounded-xl shadow-sm animate-pulse"
            ></div>
        </template>

        <!-- Stat Cards -->
        <TransitionGroup name="card" tag="div" class="contents">
            <div
                v-for="(stat, index) in statistics"
                :key="stat.title"
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 ease-out overflow-hidden group"
            >
                <div class="absolute inset-0 opacity-90 mx-3"
                     :class="cardVariants[getCardVariant(stat.title)]"></div>

                <div class="relative z-10 p-5 h-full flex flex-col justify-between bg-slate-900">
                    <div>
                        <p class="text-sm font-medium text-white/90">{{ formatTitle(stat.title) }}</p>
                        <h2 class="text-3xl font-bold text-white mt-2">
                            {{ stat.value.toLocaleString() }}
                        </h2>
                    </div>

                    <div v-if="stat?.value > 0" class="mt-4">
                        <Link
                            :href="`/dashboard/${stat.title}/view`"
                            class="inline-flex items-center text-xs font-semibold text-white/90 hover:text-white transition-colors"
                        >
                            View details
                            <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<style scoped>
/* Card enter/leave transitions */
.card-move,
.card-enter-active,
.card-leave-active {
    transition: all 0.5s ease;
}

.card-enter-from,
.card-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

.card-leave-active {
    position: absolute;
}

/* Performance optimization */
@media (prefers-reduced-motion: reduce) {
    .card-move,
    .card-enter-active,
    .card-leave-active {
        transition: none;
    }

    .group-hover\:translate-x-1:hover {
        transform: none;
    }
}
</style>
