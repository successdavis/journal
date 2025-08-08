<script setup>
import { Head, Link } from '@inertiajs/vue3'
import {ref} from "vue";

// const activeRoute = ref(route().current())
//
// // Check if link is active
// const isActive = (path) => {
//     return activeRoute.value.includes(path.replace(/^\/|\/$/g, ''))
// }
</script>

<template>
    <Head title="Admin Dashboard" />

    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar - Always visible and full height -->
        <aside class="w-64 bg-slate-900 text-slate-100 flex-shrink-0 h-full">
            <div class="h-full flex flex-col p-5">
                <!-- User info -->
                <div class="flex items-center space-x-3 mb-8 pt-2">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-lg font-bold">
                        {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <div class="font-medium text-white">{{ $page.props.auth.user.name }}</div>
                        <div class="text-xs text-slate-400">Administrator</div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1">
                    <!-- Dashboard -->
                    <Link
                        href="/admin/dashboard"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Dashboard</span>
                    </Link>

                    <!-- Content Management -->
                    <div class="px-4 pt-4 pb-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Content
                    </div>

                    <Link
                        href="/dashboard/total_articles/view"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>All Manuscripts</span>
                    </Link>

                    <Link
                        href="/dashboard/published_articles/view"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Published Articles</span>
                    </Link>

                    <!-- User Management -->
                    <div class="px-4 pt-4 pb-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        User Management
                    </div>

                    <Link
                        href="/dashboard/total_users/view"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>All Users</span>
                    </Link>

                    <Link
                        href="/super_admin/role_requests"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Role Requests</span>
                    </Link>

                    <Link
                        href="/admin/roles_permissions"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <span>Roles & Permissions</span>
                    </Link>

                    <!-- System -->
                    <div class="px-4 pt-4 pb-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        System
                    </div>

<!--                    <Link-->
<!--                        href="/admin/settings"-->
<!--                        class="flex items-center bg-slate-800 space-x-3 px-4 py-3 rounded-lg transition-all"-->
<!--                    >-->
<!--                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />-->
<!--                        </svg>-->
<!--                        <span>System Settings</span>-->
<!--                    </Link>-->

<!--                    <Link-->
<!--                        href="/admin/activity-logs"-->
<!--                        class="flex items-center bg-slate-800 space-x-3 px-4 py-3 rounded-lg transition-all"-->
<!--                    >-->
<!--                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />-->
<!--                        </svg>-->
<!--                        <span>Activity Logs</span>-->
<!--                    </Link>-->
                </nav>

                <!-- Footer -->
                <div class="pt-4 border-t bg-red-500 border-slate-800">
                    <button
                        @click="logout"
                        class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-slate-400 hover:text-white rounded-lg transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </aside>
    </div>
</template>

<style>
/* Ensure full height for html and body */
html, body {
    height: 100%;
}
</style>
