<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-xl w-full max-w-md">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Confirm Final Decision
            </h1>

            <p class="text-l text-gray-900 mb-4">
                You choose <strong class="font-semibold uppercase">{{ decision }}</strong>
            </p>

            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Are you sure this is your final decision for the review of <strong>{{ manuscriptTitle }}</strong>?
            </p>

            <!-- Comment to Author -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">
                    Comment to Author (optional)
                </label>
                <textarea
                    v-model="commentToAuthor"
                    class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600"
                    rows="3"
                />
            </div>

            <!-- Comment to Reviewer -->
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">
                    Comment to Reviewer (optional)
                </label>
                <textarea
                    v-model="commentToReviewer"
                    class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600"
                    rows="3"
                />
            </div>

            <div class="flex justify-end space-x-3">
                <button
                    @click="onCancel"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300"
                >
                    No
                </button>
                <button
                    @click="onConfirm"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                >
                    Yes
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
    decision: String,
    show: Boolean,
    manuscriptTitle: String,
})

const emit = defineEmits(['confirm', 'cancel'])

const commentToAuthor = ref('')
const commentToReviewer = ref('')

function onConfirm() {
    emit('confirm', {
        commentToAuthor: commentToAuthor.value,
        commentToReviewer: commentToReviewer.value,
    })
}

function onCancel() {
    emit('cancel')
}
</script>
