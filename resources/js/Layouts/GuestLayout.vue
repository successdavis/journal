<script setup>
import NavBar from "@/Components/NavBar.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import FooterSection from "@/Components/FooterSection.vue";
</script>

<template>
    <div class="bg-gray-50">

        <NavBar />
        <div class="flex min-h-screen bg-gray-100 sm:justify-center">
            <div class="w-full overflow-hidden bg-white  shadow-md  ">
                <slot />
            </div>
        </div>

        <FooterSection />
    </div>
</template>
