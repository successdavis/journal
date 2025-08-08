<script setup>
import Dashboard_cards from "@/Components/Super_Admin/Dashboard_cards.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import {Link} from "@inertiajs/vue3";

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
    })
}

const isScrolled = ref(false);

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 10;
    });
});
</script>

<template>
    <Head title="Journal Admin Dashboard" />

    <!-- Sticky Header with smooth shadow transition -->
    <header
        class="sticky top-0 z-10 bg-white/80 backdrop-blur-md transition-all duration-300 ease-in-out"
        :class="{'shadow-sm': isScrolled}"
    >
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Journal Admin
                </h1>
            </div>
            <div>
                <Link href="/author/submit-new-manuscript" class="bg-slate-900 text-white px-4 py-2 rounded hover:bg-slate-800">
                    + Submit New Journal
                </Link>
            </div>

            <button
                @click="logout"
                class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 flex items-center space-x-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6">
        <!-- Animated Dashboard Cards -->
        <Transition name="fade" mode="out-in">
            <Dashboard_cards class="mt-4" />
        </Transition>
    </main>
</template>

<style>
/* Smooth transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Optimized smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Performance-focused animations */
@media (prefers-reduced-motion: reduce) {
    html {
        scroll-behavior: auto;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: none;
    }
}
</style>
