<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside
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
