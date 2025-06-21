<template>
    <Head title="Submit New Manuscript" />
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-12">Submit New Manuscript</h1>

        <!-- Stepper -->
        <div class="flex items-center justify-between mb-16">
            <template v-for="(label, i) in steps" :key="i">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-full"
                        :class="{
              'bg-blue-600 text-white': currentStep === i,
              'bg-gray-300 text-gray-600': currentStep !== i
            }"
                    >
                        {{ i + 1 }}
                    </div>
                    <div class="text-sm font-medium" :class="{ 'text-blue-600': currentStep === i }">
                        {{ label }}
                    </div>
                </div>
                <div v-if="i < steps.length - 1" class="flex-1 h-1 bg-gray-300 mx-2"></div>
            </template>
        </div>

        <form @submit.prevent="submit" class="space-y-6">

            <div class="min-h-96">
                <!-- Step 1: Manuscript Details -->
                <div v-if="currentStep === 0" class="grid md:grid-cols-2 gap-6">

                    <div>
                        <InputLabel for="article_type" value="Article Type" />
                        <select
                            id="article_type"
                            v-model="form.article_type"
                            required
                            class="input-base bg-white"
                        >
                            <option value="" disabled>Select article type</option>
                            <option v-for="type in publication_type" :value="type.id">{{ type.title }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.article_type" />
                    </div>

                    <div>
                        <InputLabel for="category" value="Category" />
                        <select
                            id="category"
                            v-model="form.category"
                            required
                            class="input-base bg-white"
                        >
                            <option value="" disabled>Select article type</option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.article_type" />
                    </div>

                    <div class="md:col-span-2">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.title" type="text" required class="input-base" />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="md:col-span-2">
                        <InputLabel for="abstract" value="Abstract" />
                        <textarea id="abstract" v-model="form.abstract" rows="5" class="textarea-base" />
                        <InputError class="mt-2" :message="form.errors.abstract" />
                    </div>
                    <div class="md:col-span-2">
                        <InputLabel for="abstract" value="Brief Summary" />
                        <textarea id="abstract" v-model="form.excerpt" rows="3" class="textarea-base" />
                        <InputError class="mt-2" :message="form.errors.excerpt" />
                    </div>
                    <div class="md:col-span-2">
                        <InputLabel for="keywords" value="Keywords (comma separated)" />
                        <TextInput id="keywords" v-model="form.keywords" type="text" required class="input-base" />
                        <InputError class="mt-2" :message="form.errors.keywords" />
                    </div>
                </div>

                <!-- Step 2: Publication Info -->
                <div v-if="currentStep === 1" class="grid md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <InputLabel for="affiliation" value="Affiliation" />
                        <TextInput id="affiliation" v-model="form.affiliation" type="text" required class="input-base" />
                        <InputError class="mt-2" :message="form.errors.affiliation" />
                    </div>
                    <div>
                        <InputLabel for="journal" value="Target Journal" />
                        <TextInput id="journal" v-model="form.journal" type="text" class="input-base" />
                        <InputError class="mt-2" :message="form.errors.journal" />
                    </div>
<!--                    <div>-->
<!--                        <InputLabel for="subject_area" value="Subject Area" />-->
<!--                        <TextInput id="subject_area" v-model="form.subject_area" type="text" class="input-base"-->
<!--                                   placeholder="Academic disciplines/topics" />-->
<!--                        <InputError class="mt-2" :message="form.errors.subject_area" />-->
<!--                    </div>-->
                </div>

                <!-- Step 3: Uploads -->
                <div v-if="currentStep === 2" class="grid md:grid-cols-2 gap-6">
                    <div>
                        <InputLabel for="main_document" value="Main Document (PDF)" />
                        <input @change="form.main_document = $event.target.files[0]" type="file" accept=".pdf" class="input-file" />
                        <InputError class="mt-2" :message="form.errors.main_document" />
                    </div>
                    <div>
                        <InputLabel for="cover_letter" value="Cover Letter (PDF)" />
                        <input @change="form.cover_letter = $event.target.files[0]" type="file" accept=".pdf" class="input-file" />
                        <InputError class="mt-2" :message="form.errors.cover_letter" />
                    </div>
                    <div>
                        <InputLabel for="figures" value="Figures (optional)" />
                        <input multiple @change="form.figures = Array.from($event.target.files)" type="file" class="input-file" />
                        <InputError class="mt-2" :message="form.errors.figures" />
                    </div>
                    <div>
                        <InputLabel for="supplementary" value="Supplementary Files (optional)" />
                        <input multiple @change="form.supplementary = Array.from($event.target.files)" type="file"
                               class="input-file" />
                        <InputError class="mt-2" :message="form.errors.supplementary" />
                    </div>
                </div>

                <!-- Step 4: Declarations -->
                <div v-if="currentStep === 3" class="grid md:grid-cols-2 gap-6">
                    <div>
                        <InputLabel for="ethical_approval" value="Ethical Approval Statement" />
                        <TextInput id="ethical_approval" v-model="form.ethical_approval" type="text" class="input-base" />
                        <InputError class="mt-2" :message="form.errors.ethical_approval" />
                    </div>
                    <div>
                        <InputLabel for="conflict_of_interest" value="Conflict of Interest" />
                        <TextInput id="conflict_of_interest" v-model="form.conflict_of_interest" type="text" class="input-base" />
                        <InputError class="mt-2" :message="form.errors.conflict_of_interest" />
                    </div>
                    <div class="md:col-span-2">
                        <InputLabel for="funding_statement" value="Funding Statement" />
                        <textarea id="funding_statement" v-model="form.funding_statement" rows="3" class="textarea-base"></textarea>
                        <InputError class="mt-2" :message="form.errors.funding_statement" />
                    </div>
                </div>

                <!-- Step 5: Consent -->
                <div v-if="currentStep === 4" class="space-y-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" v-model="form.consent"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        <span class="ml-2 text-sm text-gray-700">All co-authors have consented to this submission.</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" v-model="form.originality"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        <span class="ml-2 text-sm text-gray-700">This manuscript is original and not under review elsewhere.</span>
                    </label>
                </div>

            </div>
            <!-- Step Navigation -->
            <div class="flex justify-between mt-6">
                <button type="button" @click="prevStep" v-if="currentStep > 0"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Back</button>

                <button type="button" @click="nextStep" v-if="currentStep < steps.length - 1"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Next</button>

                <PrimaryButton v-if="currentStep === steps.length - 1" :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    Submit Manuscript
                </PrimaryButton>
            </div>
        </form>

    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputLabel from "@/Components/InputLabel.vue"
import TextInput from "@/Components/TextInput.vue"
import InputError from "@/Components/InputError.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"

const steps = ['Manuscript Details', 'Publication Info', 'Uploads', 'Declarations', 'Consent']
const currentStep = ref(0)

defineProps({
    publication_type: {
        type: Object,
        required: true
    },

    categories: {
        type: Object,
        required: true
    }
})


const nextStep = () => {
    if (currentStep.value < steps.length - 1) currentStep.value++
}
const prevStep = () => {
    if (currentStep.value > 0) currentStep.value--
}

const form = useForm({
    title: '', abstract: '', keywords: '', article_type: '', affiliation: '',
    journal: '', main_document: null, figures: [], supplementary: [],
    cover_letter: null, ethical_approval: '', conflict_of_interest: '', funding_statement: '',
    consent: false, originality: false, category: '', excerpt: ''
})

const submit = () => {
    form.post('/author/submit-new-manuscript', {
        onFinish: () => {
            form.reset()
            document.querySelectorAll('input[type="file"]').forEach(input => input.value = '')
        }
    })
}
</script>

<style scoped>
.input-base {
    @apply block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600;
}
.textarea-base {
    @apply mt-1 block w-full py-2.5 px-0 text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600;
}
.input-file {
    @apply mt-1 block w-full;
}
</style>
