<template>
    <div class="pt-4 my-6">
        <div class="flex w-full justify-start">
            <div class="w-full max-w-md mx-auto">
                <select id="editorDecision"
                        v-model="selectedDecision"
                        @change="handleFinalDecision(publicationToDisplay)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option disabled value="" selected>Update status</option>
                    <option value="accepted">✅ Accept</option>
                    <option value="published">✅ Publish</option>
                    <option value="rejected">❌ Reject</option>
                    <option value="resubmitted_elsewhere">📦 Resubmit Elsewhere</option>
                    <option value="withdrawn_by_author"  class="text-gray-400">🚫 Withdrawn by Author
                        (optional)
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>


<script setup>
import {ref} from "vue";
import axios from "axios";
import {onMounted} from "vue";
let props = defineProps({
    publication: Object,
})
let emits = defineEmits('statusUpdated')
let publicationToDisplay = ref()
let selectedDecision = ref('')
onMounted(()=>{
    publicationToDisplay.value = props.publication
})

function handleFinalDecision() {
    let newStatus = selectedDecision.value
    axios.patch(`/super_admin/${props.publication.id}/update_article_status`, {newStatus})
        .then(res =>{
            alert(publicationToDisplay.value.title + ' status has been updated to '+ newStatus)
            emits('statusUpdated', {payload: res.data})
        })
}
</script>


