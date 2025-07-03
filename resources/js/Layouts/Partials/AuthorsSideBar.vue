<template>
    <aside class="h-full">
        <div class="overflow-y-auto py-4 px-3 bg-gray-800 h-full rounded">
            <ul class="space-y-2 text-gray-200">
                <li>
                    <Link :href="'/' + $page.props.auth.user.role + '/dashboard'" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-100">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 group-hover" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="ml-3">Home</span>
                    </Link>
                </li>

                <li>
                    <Link href="/author/publications" class="flex items-center p-2 pl-11 w-full text-base font-normal rounded-lg transition duration-75 group hover:bg-gray-100">Publications</Link>
                </li>
                <li>
                    <Link href="/author/my-submissions" class="flex items-center p-2 pl-11 w-full text-base font-normal rounded-lg transition duration-75 group hover:bg-gray-100">My Submissions</Link>
                </li>
                <li>
                    <Link href="/author/submit-new-manuscript" class="flex items-center p-2 pl-11 w-full text-base font-normal rounded-lg transition duration-75 group hover:bg-gray-100">Submit New Manuscript </Link>
                </li>


                <li>
                    <Link href="/home" class="flex absolute bottom-5 items-center p-2 text-base font-normal rounded-lg hover:bg-gray-100">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Exit Dashboard</span>
                    </Link>
                </li>
            </ul>

        </div>
    </aside>

</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import AccordionMenu from "@/Layouts/Partials/AccordionMenu.vue";
</script>

<style >
/* For Webkit browsers (Chrome, Safari) */
::-webkit-scrollbar {
    width: 4px; /* You can adjust this value to make it thinner or thicker */
}

::-webkit-scrollbar-thumb {
    background-color: #888; /* Color of the scrollbar thumb */
}

/* For Firefox */
/* Note: Firefox does not support styling the scrollbar width directly,
   but you can use the color property for the scrollbar thumb */
* {
    scrollbar-color: #888 transparent;
}

/* For Microsoft Edge */
/* Note: Microsoft Edge (Chromium-based) supports styling similar to Webkit browsers */
* {
    scrollbar-width: thin;
    scrollbar-color: #888 transparent;
}

</style>
