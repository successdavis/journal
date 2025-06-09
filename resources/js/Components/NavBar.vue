<template>
    <nav class=" border-b border-gray-200 dark:border-gray-700 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left: Logo -->
            <div class="flex ">

                <div class="flex items-center gap-4">
                    <Link href="/" class="py-2 mx-3 text-gray-700 hover:text-blue-600">
                        <span class="text-xl font-bold">JournalSite</span>
                    </Link>
                </div>

                <div class="hidden lg:flex lg:gap-6">
                    <Link href="about-us" class="py-2 mx-3 text-gray-700 hover:text-blue-600">About Us</Link>
                    <Link href="all-journals" class="py-2 mx-3 text-gray-700 hover:text-blue-600">All Journals</Link>
                    <Link href="all-articles" class="py-2 mx-3 text-gray-700 hover:text-blue-600">All Articles</Link>
                </div>
            </div>

            <!-- Center: Submit button (hidden on small) -->
            <div class="hidden lg:flex">
                <Link
                    href="submit-your-research"
                    class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                    Submit Your Research
                </Link>
            </div>

            <!-- Right: Icons and Mobile Toggle -->
            <div class="flex items-center gap-4">
                <!-- Icons (visible on small only) -->
                <div class="lg:hidden flex items-center gap-3">
                    <button class="text-gray-600 dark:text-gray-300">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="text-gray-600 dark:text-gray-300">
                        <i class="fas fa-user"></i>
                    </button>
                </div>

                <!-- Toggle Button -->
                <button
                    @click="menuOpen = !menuOpen"
                    class="inline-flex items-center justify-center p-2 text-gray-500 rounded-md lg:hidden hover:text-gray-900 focus:outline-none"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            :class="{ hidden: menuOpen }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ hidden: !menuOpen }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
                <!-- Right Nav Links (desktop) -->
                <div v-if="user" class="hidden lg:flex items-center gap-4">
                    <Link v-if="user.role === 'editor'" href="editor/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                    <Link v-else-if="user.role === 'reviewer'" href="reviewer/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                    <Link v-else-if="user.role === 'admin'" href="admin/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                    <Link v-else href="author/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                </div>
                <div v-else class="hidden lg:flex items-center gap-4">
                    <Link href="search" class="text-sm font-medium text-gray-700 hover:text-blue-600">Search</Link>
                    <Link href="login" class="text-sm font-medium text-gray-700 hover:text-blue-600">Login</Link>
                    <Link href="register" class="text-sm font-medium text-gray-700 hover:text-blue-600">Register</Link>
                </div>
            </div>
        </div>

        <!-- Main Menu (visible on lg, toggle on small) -->
        <div
            :class="['lg:flex justify-between items-center mt-2', menuOpen ? 'block' : 'hidden']"
            class="w-full lg:mt-0"
        >
            <div class="flex flex-col lg:hidden lg:gap-6">
                <Link href="about-us" class="py-2 text-gray-700 hover:text-blue-600">About Us</Link>
                <Link href="all-journals" class="py-2 text-gray-700 hover:text-blue-600">All Journals</Link>
                <Link href="all-articles" class="py-2 text-gray-700 hover:text-blue-600">All Articles</Link>
            </div>

            <!-- Submit Button (mobile) -->
            <div class="flex lg:hidden mt-2">
                <Link
                    href="submit-your-research"
                    class="w-full text-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700"
                >
                    Submit Your Research
                </Link>
            </div>

            <div v-if="user" class="flex flex-col lg:hidden gap-2 mt-4">
                <Link v-if="user.role === 'editor'" href="editor/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                <Link v-else-if="user.role === 'reviewer'" href="reviewer/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                <Link v-else-if="user.role === 'admin'" href="admin/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
                <Link v-else href="author/dashboard" class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</Link>
            </div>
            <div v-else class="flex flex-col lg:hidden gap-2 mt-4">
                <Link href="search" class="text-gray-700 hover:text-blue-600">Search</Link>
                <Link href="login" class="text-gray-700 hover:text-blue-600">Login</Link>
                <Link href="register" class="text-gray-700 hover:text-blue-600">Register</Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import { Link} from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()
const user = props.auth.user
const menuOpen = ref(false)
</script>
