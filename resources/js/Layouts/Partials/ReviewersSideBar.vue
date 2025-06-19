<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside
            :class="[
        'fixed md:static top-0 left-0 z-40 h-screen w-64 transition-transform transform md:translate-x-0',
        showSidebar ? 'translate-x-0' : '-translate-x-full',
        'bg-indigo-50 text-indigo-900 shadow-lg p-5'
      ]"
        >
            <div class="text-lg font-bold mb-6">
                Reviews Panel
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/dashboard"
                    class="hover:bg-indigo-100 px-3 py-2 rounded transition"
                >
                    Home
                </Link>
                <Link
                    href="/reviewer/assigned-reviews"
                    class="hover:bg-indigo-100 px-3 py-2 rounded transition"
                >
                    Assigned Reviews
                </Link>
                <Link
                    href="/reviewer/review-history"
                    class="hover:bg-indigo-100 px-3 py-2 rounded transition"
                >
                    Review History
                </Link>
            </nav>
        </aside>

            <!-- Top Bar for Mobile -->
            <div class="absolute top-0 left-0  z-50 flex items-center justify-between md:hidden p-4 bg-white shadow">
                <div class="font-semibold text-indigo-900">Reviews Panel</div>
                <button @click="showSidebar = !showSidebar" class="text-indigo-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const showSidebar = ref(false)
</script>
