<template>
    <div class="flex relative h-screen overflow-hidden bg-gray-100 dark:bg-gray-900">
        <!-- Mobile Toggle Button -->
        <!-- Mobile Toggle Button -->
        <button
            @click="toggleSidebar"
            :class="[
    'md:hidden fixed top-4 z-50 bg-gray-800 hover:bg-gray-700 text-white p-2 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out',
    isSidebarOpen ? 'left-72' : 'left-4'
  ]"
            aria-label="Toggle sidebar"
        >
            <span v-if="!isSidebarOpen">☰</span>
            <span v-else>&times;</span>
        </button>


        <!-- Mobile Overlay -->
        <div
            v-if="isSidebarOpen"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 md:hidden"
            @click="closeSidebar"
        ></div>

        <!-- Sidebar -->
        <aside
            :class="[
        'w-72 h-full bg-white dark:bg-gray-800 border-r dark:border-gray-700 overflow-y-auto fixed top-0 left-0 z-50 transition-transform duration-300 ease-in-out transform md:translate-x-0',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
      ]"
        >
            <component :is="componentToRender" @click="closeSidebar" />
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-72 p-4 overflow-y-auto">
            <!-- Flash Messages -->
            <Flash
                v-if="flash.success"
                :message="flash.success"
                type="success"
                @hide="clearFlash('success')"
            />
            <Flash
                v-if="flash.error"
                :message="flash.error"
                type="error"
                @hide="clearFlash('error')"
            />
            <Flash
                v-if="flash.message"
                :message="flash.message"
                type="info"
                @hide="clearFlash('info')"
            />

            <!-- Page Slot -->
            <slot />
        </main>
    </div>
</template>

<script>
import AuthorSideBar from "@/Layouts/Partials/AuthorsSideBar.vue"
import EditorSideBar from "@/Layouts/Partials/EditorsSideBar.vue"
import ReviewersSideBar from "@/Layouts/Partials/ReviewersSideBar.vue"
import ReadersSideBar from "@/Layouts/Partials/ReadersSideBar.vue"
import Admin_Sidebar from "@/Layouts/Partials/Admin_Sidebar.vue"
import Flash from "@/Components/FlashMessage.vue"

export default {
    components: {
        Admin_Sidebar,
        AuthorSideBar,
        EditorSideBar,
        ReviewersSideBar,
        ReadersSideBar,
        Flash,
    },

    props: {
        userRole: String,
    },

    data() {
        const role = this.$page.props.auth.user.role || "guest"
        return {
            userRole: role,
            isSidebarOpen: false,
        }
    },

    computed: {
        componentToRender() {
            switch (this.userRole) {
                case "Super_Admin":
                    return Admin_Sidebar
                case "Editor":
                    return EditorSideBar
                case "Reviewer":
                    return ReviewersSideBar
                case "Author":
                case "Director":
                    return AuthorSideBar
                case "Reader":
                    return ReadersSideBar
                default:
                    return ReadersSideBar
            }
        },

        flash() {
            return this.$page.props.flash || {}
        },
    },

    methods: {
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen
        },

        closeSidebar() {
            this.isSidebarOpen = false
        },

        clearFlash(type) {
            if (this.$page.props.flash[type]) {
                this.$page.props.flash[type] = null
            }
        },
    },
}
</script>
