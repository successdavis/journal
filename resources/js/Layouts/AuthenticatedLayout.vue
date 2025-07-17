<template>
    <div class="flex relative">
        <!-- Mobile toggle button -->
        <button
            @click="toggleSidebar"
            class="md:hidden fixed top-4 left-4 z-50 bg-gray-800 text-white p-2 rounded focus:outline-none"
        >
            ☰
        </button>

        <!-- Mobile Overlay -->
        <div
            v-if="isSidebarOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
            @click="closeSidebar"
        ></div>

        <!-- Sidebar -->
        <div
            :class="[
        'w-72 sidebar h-full overflow-y-scroll fixed z-50 transform transition-transform duration-300 md:translate-x-0 md:block',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
      ]"
            aria-label="Sidebar"
        >
            <component :is="componentToRender" @click="closeSidebar" />
        </div>

        <!-- Main Content -->
        <div class="md:ml-72 py-4 px-3 w-full overflow-y-scroll main-content">
            <Flash
                v-if="flash && flash.success"
                :message="flash.success"
                type="success"
                @hide="clearFlash('success')"
            />
            <Flash
                v-if="flash && flash.error"
                :message="flash.error"
                type="error"
                @hide="clearFlash('error')"
            />
            <Flash
                v-if="flash && flash.message"
                :message="flash.message"
                type="info"
                @hide="clearFlash('info')"
            />
            <slot />
        </div>
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

    data() {
        const role = this.$page.props.auth.user.role || 'guest'
        return {
            userRole: role,
            isSidebarOpen: false,
        }
    },

    computed: {
        componentToRender() {
            switch (this.userRole) {
                case 'Super_Admin':
                    return Admin_Sidebar
                case 'Editor':
                    return EditorSideBar
                case 'Reviewer':
                    return ReviewersSideBar
                case 'Author':
                case 'Director':
                    return AuthorSideBar
                case 'Reader':
                    return ReadersSideBar
                default:
                    return 'GuestComponent'
            }
        },

        flash() {
            return this.$page.props.flash || {}
        },

        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen
        },
        closeSidebar() {
            this.isSidebarOpen = false
        },
    },

    props: {
        userRole: String,
    },

    methods: {
        clearFlash(type) {
            this.$page.props.flash[type] = null
        }
    },
}
</script>

<style scoped>
@media print {
    .sidebar {
        display: none !important;
    }

    .main-content {
        width: 100% !important;
        margin: 0 !important;
    }
}
</style>
