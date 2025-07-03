<template>
    <div
        @click="displayNotificationMessages"
        :class="[
    'fixed inset-0 bg-black opacity-10 z-40',
    showMessages ? '' : 'hidden'
  ]"
    ></div>

    <div class="relative max-w-2xl w-full h-full flex items-center justify-center">
        <!-- Notification icon -->
        <button class="absolute z-50" @click="displayNotificationMessages">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-6 h-6" viewBox="0 0 448 512">
                <path
                    fill="gray"
                    d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"
                />
            </svg>
            <!-- Notification badge -->
            <span
                v-if="notificationsCount > 0"
                class="absolute  -top-4 -right-50   transform -translate-x-1/2  bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                        {{ notificationsCount }}
  </span>
        </button>

        <!-- Centered child -->
        <div :class="['absolute top-6 left-1/2 transform -translate-x-1/2 z-50',
        showMessages ? '' : 'hidden'
]">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Notifications</h2>
                <ul v-if="notifications.length > 0" class="text-sm text-gray-600 space-y-2">
                    <li v-for="(notification, index) in notifications" class="max-w-2xl break-words flex items-end justify-left">
                       📢 <span :class="['px-2 ',
                            notification.status ? 'text-gray-600 italic' : 'font-bold'
                       ]">{{ notification.message }}</span>
                    </li>
                </ul>
                <ul v-else class=" text-sm text-gray-400 italic text-center">
                    <li>You have no messages yet</li>
                </ul>

            </div>
        </div>

    </div>
</template>
<script setup>

import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps({
    user: Object
})

const notifications = ref([])
const notificationsCount = ref(0)


let showMessages = ref(false)
const getNotifications = () => {
    axios.get(`/get_notifications/${props.user.id}`)
        .then(res => {
            notifications.value = res.data[0]
            notificationsCount.value = res.data[1]
        })
}

const displayNotificationMessages = () => {
    axios.patch(`/notifications_read/${props.user.id}`)
        .then(res => {
            notifications.value = res.data
            showMessages.value = !showMessages.value
            notificationsCount.value = 0
        })

}

onMounted(() => {
    getNotifications()
})


</script>
