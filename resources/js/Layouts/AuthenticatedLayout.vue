<template>
    <div class="flex">
        <div class="w-72 sidebar fixed overflow-y-scroll h-full hidden md:block" aria-label="Sidebar">
            <!--            <Sidebar></Sidebar>-->
            <component :is="componentToRender"></component>
        </div>

        <div class="md:ml-72 py-4 px-3 w-full overflow-y-scroll main-content ">
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
import EditorSideBar from "@/Layouts/Partials/EditorsSideBar.vue";
import ReviewersSideBar from "@/Layouts/Partials/ReviewersSideBar.vue";
import ReadersSideBar from "@/Components/ReadersSideBar.vue";
import Flash from '@/Components/FlashMessage.vue'

export default {
    components: {
        AuthorSideBar,
        EditorSideBar,
        ReviewersSideBar,
        ReadersSideBar,
        Flash
    },
    data() {
        const role = this.$page.props.auth.user.role || 'guest';
        return {
            userRole: role
        }
    },

    methods: {
        clearFlash(type) {
            this.$page.props.flash[type] = null
        }
    },
    computed: {
        componentToRender() {
            switch (this.userRole) {
                case 'Editor':
                    return EditorSideBar;
                case 'Reviewer':
                    return ReviewersSideBar;
                case 'Author':
                    return 'AuthorSideBar';
                case 'Director':
                    return AuthorSideBar;
                    case 'Reader':
                    return ReadersSideBar;
                case 'guest':
                    return 'GuestComponent';
                // add additional cases for other user roles
                default:
                    return 'GuestComponent'; // fallback component if role is not recognized
            }
        },

        flash() {
            // return usePage().props.value.flash || {}
        }
    },

    props: {
        userRole: String
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
