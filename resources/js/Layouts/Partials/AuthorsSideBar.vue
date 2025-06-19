<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside
            :class="[
        'fixed md:static top-0 left-0 z-40 h-screen w-64 transition-transform transform md:translate-x-0',
        showSidebar ? 'translate-x-0' : '-translate-x-full',
        'bg-slate-200 text-slate-900 shadow-lg p-5'
      ]"
        >
            <div class="text-lg font-bold mb-6">
                Author: {{ userName }}
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/author/dashboard"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                >
                    Home
                </Link>
                <Link
                    href="/author/my-submissions"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                >
                    My Submissions
                </Link>
                <Link
                    href="/author/submit-new-manuscript"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                >
                    Submit New Manuscript
                </Link>
            </nav>
        </aside>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const showSidebar = ref(false)
const userName = 'John Doe' // You can pass this as a prop or use store if needed
</script>
