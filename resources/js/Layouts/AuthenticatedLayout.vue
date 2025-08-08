<template>
    <div class="flex relative h-screen overflow-hidden bg-gray-50 dark:bg-gray-900">
        <!-- Mobile Toggle Button - Improved Design -->
        <button
            @click="toggleSidebar"
            :class="[
        'md:hidden fixed top-4 z-50 bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full shadow-lg',
        'focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
        'transition-all duration-300 ease-in-out transform',
        isSidebarOpen ? 'left-64 ml-2 rotate-90' : 'left-4'
      ]"
            aria-label="Toggle sidebar"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    :d="isSidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"
                />
            </svg>
        </button>

        <!-- Mobile Overlay with Animation -->
        <Transition name="fade">
            <div
                v-if="isSidebarOpen"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
                @click="closeSidebar"
            />
        </Transition>

        <!-- Sidebar with Enhanced Animation -->
        <Transition name="slide">
            <aside
                :class="[
          'w-64 h-full bg-slate-900 border-r overflow-y-auto',
          'fixed top-0 left-0 z-50 shadow-xl md:shadow-none',
          'transition-transform duration-300 ease-in-out transform',
          isSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
        ]"
            >
                <component
                    :is="componentToRender"
                    @click="closeSidebar"
                    class="h-full w-full"
                />
            </aside>
        </Transition>

        <!-- Main Content Area -->
        <main
            :class="[
        'flex-1 p-4 overflow-y-auto transition-all duration-300',
        'md:ml-64', // Regular sidebar width
      ]"
        >
            <!-- Enhanced Flash Messages -->
            <TransitionGroup name="flash">
                <Flash
                    v-if="flash.success"
                    key="success"
                    :message="flash.success"
                    type="success"
                    @hide="clearFlash('success')"
                    class="mb-4"
                />
                <Flash
                    v-if="flash.error"
                    key="error"
                    :message="flash.error"
                    type="error"
                    @hide="clearFlash('error')"
                    class="mb-4"
                />
                <Flash
                    v-if="flash.message"
                    key="info"
                    :message="flash.message"
                    type="info"
                    @hide="clearFlash('info')"
                    class="mb-4"
                />
            </TransitionGroup>

            <!-- Page Slot -->
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Flash from "@/Components/FlashMessage.vue"
import Admin_Sidebar from "@/Layouts/Partials/Admin_Sidebar.vue"
import AuthorSideBar from "@/Layouts/Partials/AuthorsSideBar.vue"
import EditorSideBar from "@/Layouts/Partials/EditorsSideBar.vue"
import ReviewersSideBar from "@/Layouts/Partials/ReviewersSideBar.vue"
import ReadersSideBar from "@/Layouts/Partials/ReadersSideBar.vue"

const page = usePage()
const isSidebarOpen = ref(false)

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value
}

const closeSidebar = () => {
    isSidebarOpen.value = false
}

const clearFlash = (type) => {
    if (page.props.flash[type]) {
        page.props.flash[type] = null
    }
}

const userRole = computed(() => page.props.auth.user?.role || "guest")

const componentToRender = computed(() => {
    switch (userRole.value) {
        case "Super_Admin": return Admin_Sidebar
        case "Editor": return EditorSideBar
        case "Reviewer": return ReviewersSideBar
        case "Author":
        case "Director": return AuthorSideBar
        case "Reader": return ReadersSideBar
        default: return ReadersSideBar
    }
})

const flash = computed(() => page.props.flash || {})
</script>

<style scoped>
/* Slide transition for sidebar */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}

/* Fade transition for overlay */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Flash messages transition */
.flash-move,
.flash-enter-active,
.flash-leave-active {
    transition: all 0.3s ease;
}

.flash-enter-from,
.flash-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

.flash-leave-active {
    position: absolute;
    width: calc(100% - 2rem);
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .slide-enter-active,
    .slide-leave-active,
    .fade-enter-active,
    .fade-leave-active,
    .flash-move,
    .flash-enter-active,
    .flash-leave-active {
        transition: none;
    }
}
</style>
