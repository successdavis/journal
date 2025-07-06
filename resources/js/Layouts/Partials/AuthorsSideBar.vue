<template>
    <sidebar>
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



    </sidebar>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
</script>
