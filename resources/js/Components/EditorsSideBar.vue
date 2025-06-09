
<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside
            :class="[
        'fixed md:static top-0 left-0 z-40 h-screen w-64 transition-transform transform md:translate-x-0',
        showSidebar ? 'translate-x-0' : '-translate-x-full',
        'bg-teal-50 text-teal-900 shadow-lg p-5'
      ]"
        >
            <div class="text-lg font-bold mb-6">
                Editor Panel
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/editor/dashboard"
                    class="hover:bg-teal-100 px-3 py-2 rounded transition"
                >
                    Home
                </Link>
                <Link
                    href="/editor/all-submissions"
                    class="hover:bg-teal-100 px-3 py-2 rounded transition"
                >
                    All Submissions
                </Link>
                <Link
                    href="/editor/assign-reviewers"
                    class="hover:bg-teal-100 px-3 py-2 rounded transition"
                >
                    Assign Reviewers
                </Link>
                <Link
                    href="/editor/make-decisions"
                    class="hover:bg-teal-100 px-3 py-2 rounded transition"
                >
                    Make Decisions
                </Link>
            </nav>
        </aside>

            <!-- Top Bar for Mobile -->
            <div class="absolute top-0 left-0 z-50 flex items-center justify-between md:hidden p-4 bg-white shadow">
                <div class="font-semibold text-teal-900">Editor Panel</div>
                <button @click="showSidebar = !showSidebar" class="text-teal-900 focus:outline-none">
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
