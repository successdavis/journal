<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8 text-center">
      <!-- Success Icon -->
      <div class="flex justify-center mb-4">
        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.5 12.75l6 6 9-13.5" />
        </svg>
      </div>

      <!-- Success Message -->
      <h2 class="text-2xl font-semibold text-gray-800 mb-2">Submission Successful!</h2>
      <p class="text-gray-600 mb-6">
        Your journal submission has been received and is now awaiting editorial review.
        You will be notified via email once a decision has been made.
      </p>

      <!-- Return Button -->
      <button
        @click="$inertia.visit('/author/dashboard')"
        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Go to Dashboard
      </button>
    </div>
  </div>
</template>
