<template>

    <Head title="Admin Dashboard" />

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
                Admin: {{ $page.props.auth.user.name }}
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/admin/dashboard"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                >
                    Dashboard
                </Link>
                <Link
                    href="/super_admin/role_requests"
                    class="hover:bg-slate-300 px-3 py-2 rounded transition"
                >
                    Role Requests
                </Link>
            </nav>
        </aside>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {Head, Link} from '@inertiajs/vue3'
import AccordionMenu from "@/Layouts/Partials/AccordionMenu.vue";

const showSidebar = ref(false)

</script>
