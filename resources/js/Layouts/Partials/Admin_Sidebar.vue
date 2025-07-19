<template>
    <Head title="Admin Dashboard" />

    <div class="flex h-screen bg-gray-100">
        <!-- Toggle button for mobile -->

        <!-- Sidebar -->
        <aside
            class=" fixed md:static top-0 left-0 z-40 h-screen w-64 bg-slate-200 text-slate-900 shadow-lg p-5 transition-transform duration-300 ease-in-out"
        >
            <div class="text-lg font-bold mb-6">
                Admin: {{ $page.props.auth.user.name }}
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/admin/dashboard"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                    @click="closeSidebar"
                >
                    Dashboard
                </Link>
                <Link
                    href="/super_admin/role_requests"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                    @click="closeSidebar"
                >
                    Role Requests
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

const showSidebar = ref(false)

const toggleSidebar = () => {
    showSidebar.value = !showSidebar.value
}

const closeSidebar = () => {
    showSidebar.value = false
}
</script>
