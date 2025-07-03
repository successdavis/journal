<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                   User name
                </th>
                <th scope="col" class="px-6 py-3">
                    Role requested
                </th>
                <th scope="col" class="px-6 py-3">
                    status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(roleRequest, index) in displayedRoles"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-blue-100">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{roleRequest.user.name}}
                </th>
                <td class="px-6 py-4">
                    {{ roleRequest.role.name }}
                </td>
                <td :class="['px-6 py-4 ',
                roleRequest.status === 'Rejected'? 'text-red-500': '',
                roleRequest.status === 'Accepted'? 'text-green-500': '',
                ]">
                    {{ roleRequest.status }}
                </td>
                <td
                    v-if="roleRequest.status === 'Pending'"
                    class=" py-4 flex items-start justify-start">
                    <button
                        @click="takeAction(roleRequest.id, 'Accepted', roleRequest.user.id, roleRequest.role.id)"
                        class="mx-2 bg-teal-600 text-white px-4 py-1 rounded-md hover:bg-teal-700 transition">
                        Accept
                    </button>
                    <button

                        @click="takeAction(roleRequest.id, 'Rejected', roleRequest.user.id, roleRequest.role.id)"
                        class="mx-2 bg-red-600 text-white px-4 py-1 rounded-md hover:bg-red-700 transition">
                        Reject
                    </button>
                </td>
                <td
                    v-else
                    class=" py-4 flex items-start justify-start">
                    <button

                        class="mx-2 bg-gray-600 opacity-50 text-white px-4 py-1 rounded-md hover:bg-tgray-400 transition  cursor-not-allowed">
                        Accept
                    </button>
                    <button
                        class="mx-2 bg-gray-600 opacity-50 text-white px-4 py-1 rounded-md hover:bg-gray-400 transition cursor-not-allowed">
                        Reject
                    </button>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import {ref} from "vue";
import axios from "axios";
let props = defineProps({
    roleRequests: Object
})
const displayedRoles = ref([])
displayedRoles.value = props.roleRequests


const takeAction = (roleRequestId, option,  user_id, role_id) =>{
    console.log(option)
    axios.patch(`/super_admin/response_to_role_request/${roleRequestId}`, { option, user_id, role_id }, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(res=>{
            displayedRoles.value = res.data
        })
}


</script>

<style scoped>

</style>
