<template>
  <section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex flex-col md:flex-row items-center justify-between">
      <!-- Left Image Section -->
      <div class="md:w-1/2 w-full mb-10 md:mb-0">
        <img :src="imageSrc" alt="Exceptional Children" class="rounded shadow-lg w-full object-cover" />
      </div>

      <!-- Right Text Section -->
      <div class="md:w-1/2 w-full text-center md:text-left">
        <p class="text-teal-500 text-sm uppercase tracking-wide mb-2">_EXCEPTIONAL</p>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
          We <span class="text-gray-800">Support</span> <br />
          <span class="text-teal-500">Exceptional Children</span>
        </h1>
        <p class="text-gray-600 mb-6">
          At the National Association for Exceptional Children, we aim to provide quality support, advocacy, and resources to ensure no child is left behind.
        </p>
        <button class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded transition">
          Summit a paper
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  imageSrc: {
    type: String,
    default: '/images/exceptional-children.jpg', // Use your uploaded image path
  }
});
</script>
