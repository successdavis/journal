<template>
    <div class="bg-white text-gray-800 min-h-screen">
        <!-- Hero Section -->
        <section
            class="relative text-white py-20 px-6 bg-cover bg-center"
            style="background-image: url('/images/bg-image.png')"
        >
            <!-- Overlay -->
            <div class="absolute inset-0 bg-blue-900 opacity-80"></div>

            <!-- Content -->
            <div class="relative max-w-5xl mx-auto text-center z-10">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">About Us</h1>
                <p class="text-lg md:text-xl font-medium">
                    National Association for Exceptional Children
                </p>
            </div>
        </section>

        <!-- Mission, Vision, and Overview -->
        <section class="max-w-6xl mx-auto px-6 py-16 space-y-16">
            <!-- Overview -->
            <div class="space-y-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Who We Are</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    The National Association for Exceptional Children (NAEC) is a professional body dedicated to advocating for, supporting, and empowering children with exceptionalities across Nigeria and beyond. We bring together educators, parents, specialists, and stakeholders who share a commitment to providing inclusive education, awareness, and policy development for every exceptional child to thrive.
                </p>
            </div>

            <!-- Mission -->
            <div class="space-y-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Our Mission</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    To promote the well-being, development, and rights of exceptional children through inclusive education, advocacy, capacity building, and community engagement.
                </p>
            </div>

            <!-- Vision -->
            <div class="space-y-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Our Vision</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    A society where all exceptional children are empowered to reach their full potential and participate meaningfully in every aspect of life.
                </p>
            </div>

            <!-- Core Values -->
            <div class="space-y-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Our Core Values</h2>
                <ul class="list-disc list-inside text-lg text-gray-700 space-y-2">
                    <li>Inclusion</li>
                    <li>Empowerment</li>
                    <li>Equity</li>
                    <li>Compassion</li>
                    <li>Collaboration</li>
                    <li>Advocacy</li>
                    <li>Excellence</li>
                </ul>
            </div>
        </section>
    </div>
</template>

<script setup>
import Layout from '@/Layouts/GuestLayout.vue'


defineOptions({
    layout: Layout,
})
</script>
