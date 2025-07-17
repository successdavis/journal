<template>
    <div class="w-full max-w-sm sm:max-w-md md:max-w-lg bg-white border border-gray-200 rounded-2xl shadow-md dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <img
                class="p-4 sm:p-6 rounded-t-2xl w-full object-cover aspect-[4/3]"
                :src="publication.image"
                alt="product image"
            />
        </a>
        <div class="px-4 sm:px-6 pb-5">
            <a href="#">
                <h5 class="text-lg sm:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {{ publication.title }}
                </h5>
            </a>

            <div class="flex flex-wrap items-center mt-2.5 mb-4 gap-2">
                <div class="flex space-x-1 rtl:space-x-reverse">
                    <svg
                        v-for="i in 4"
                        :key="i"
                        class="w-4 h-4 text-yellow-300"
                        fill="currentColor"
                        viewBox="0 0 22 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752
              0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463
              9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0
              2.226 1.616L11 17.033l4.518
              2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537
              9.2a1.523 1.523 0 0 0 .387-1.575Z"
                        />
                    </svg>
                    <svg
                        class="w-4 h-4 text-gray-200 dark:text-gray-600"
                        fill="currentColor"
                        viewBox="0 0 22 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534
              1.534 0 0 0-2.752 0L7.365
              5.847l-5.051.734A1.535 1.535 0 0 0
              1.463 9.2l3.656 3.563-.863
              5.031a1.532 1.532 0 0 0 2.226
              1.616L11 17.033l4.518
              2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537
              9.2a1.523 1.523 0 0 0 .387-1.575Z"
                        />
                    </svg>
                </div>
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"
                >
          5.0
        </span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <span class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
          ${{ publication.amount }}
        </span>

                <button
                    v-if="$page.props.auth.user"
                    @click="handleReadMore(publication.id, $page.props.auth.user.id)"
                    class="text-white w-full sm:w-auto bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Continue to payment
                </button>

                <Link
                    v-else
                    href="/login"
                    class="text-white w-full sm:w-auto bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Continue to payment
                </Link>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    publication: Object,
});

const handleReadMore = (publicationId, userId) => {
    axios.post(`/reader/payment/${userId}/${publicationId}`).then((res) => {
        window.location.href = `/reader/payment/${userId}/${publicationId}/${res.data.receipt.id}`;
    });
};
</script>
