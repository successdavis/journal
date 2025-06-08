<script setup>
import NavBar from "@/Components/NavBar.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <div class="px-6 lg:px-12 bg-gray-50">

        <NavBar />
        <div
            class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
        >
            <div class="flex items-center gap-4">
                <Link href="/" class="py-2 mx-3 text-gray-700 hover:text-blue-600">
                    <span class="text-xl font-bold">JournalSite</span>
                </Link>
            </div>

            <div
                class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
            >
                <slot />
            </div>
        </div>

        <Footer />
    </div>
</template>
