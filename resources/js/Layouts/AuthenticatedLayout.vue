<template>
    <div>
        <div class="flex min-h-screen bg-gray-100">
            <nav
                class="flex border-b border-gray-100 bg-white"
            >
                <!-- Primary Navigation Menu -->
                <div v-if="role === 'editor'" class="flex lg:fixed">
                    <EditorsSideBar/>
                </div>
                <div v-else-if="role === 'reviewer'" class="flex lg:fixed">
                    <ReviewersSideBar/>
                </div>
                <div v-else-if="role === 'admin'" class="flex lg:fixed">
                    <AdminSideBar />
                </div>
                <div v-else class="flex lg:fixed">
                    <AuthorsSideBar/>
                </div>
            </nav>
            <!-- Page Content -->
            <main class="mx-6  lg:ml-72 px-6 w-full">
                <div>
                    <div class="">
                        <div class="flex h-16 justify-end">
                            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                                <!-- Settings Dropdown -->
                                <div class="relative right-0 ms-3">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                :href="route('profile.edit')"
                                            >
                                                Profile
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <slot/>
            </main>
        </div>
    </div>
</template>


<script setup>
import {onMounted, ref} from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import AuthorsSideBar from "@/Components/AuthorsSideBar.vue";
import ReviewersSideBar from "@/Components/ReviewersSideBar.vue";
import EditorsSideBar from "@/Components/EditorsSideBar.vue";


let props = defineProps({
    role: String
})

onMounted(() => {
    console.log(props.role)
})
</script>
