<template>
    <div class="flex h-screen">
        <!-- Sidebar (visible only on md and up) -->
        <aside
            class="block w-64 h-full bg-indigo-50 text-indigo-900 shadow-lg p-5"
        >
            <div class="text-lg font-bold mb-6">
                Readers Panel
            </div>

            <nav class="flex flex-col space-y-3 text-sm">
                <Link
                    href="/reader/dashboard"
                    class="hover:bg-indigo-100 px-3 py-2 rounded transition"
                >
                    Home
                </Link>
                <Link
                    :href="`/reader/history/${$page.props.auth.user.id}`"
                    class="hover:bg-indigo-100 px-3 py-2 rounded transition"
                >
                    History
                </Link>
            </nav>
        </aside>

        <!-- Mobile Top Bar -->
        <div class="md:hidden fixed top-0 left-0 w-full z-50 flex items-center justify-between p-4 bg-white shadow">
            <div class="font-semibold text-indigo-900">Readers Panel</div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6 mt-16 md:mt-0 overflow-y-auto">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
