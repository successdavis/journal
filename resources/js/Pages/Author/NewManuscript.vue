<template>
    <AuthenticatedLayout>
        <Head title="Submit New Manuscript" />
        <h1 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white mb-12">
            Submit New Manuscript
        </h1>

        <form @submit.prevent="submit" class="space-y-6">

            <!-- Manuscript Details -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput id="title" v-model="form.title" type="text"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" required
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div>
                    <InputLabel for="article_type" value="Article Type" />
                    <TextInput id="article_type" v-model="form.article_type" type="text"
                               class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600"
                               placeholder="E.g. Original Research, Review Article, Case Report"
                               required
                    />
                    <InputError class="mt-2" :message="form.errors.article_type" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="abstract" value="Abstract" />
                    <textarea id="abstract" v-model="form.abstract" rows="5"
                              class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600"
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.abstract" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="keywords" value="Keywords (comma separated)" />
                    <TextInput id="keywords" v-model="form.keywords" type="text"
                               class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" required />
                    <InputError class="mt-2" :message="form.errors.keywords" />
                </div>
            </div>

            <!-- Author Info -->
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <InputLabel for="affiliation" value="Affiliation" />
                    <TextInput id="affiliation" v-model="form.affiliation" type="text" class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" required />
                    <InputError class="mt-2" :message="form.errors.affiliation" />
                </div>
            </div>

            <!-- Journal Info -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="journal" value="Target Journal" />
                    <TextInput id="journal" v-model="form.journal" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.journal" />
                </div>

                <div>
                    <InputLabel for="subject_area" value="Subject Area" />
                    <TextInput id="subject_area" v-model="form.subject_area" type="text"
                               placeholder="Academic disciplines/topics"
                               class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" />
                    <InputError class="mt-2" :message="form.errors.subject_area" />
                </div>
            </div>

            <!-- Uploads -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="main_document" value="Main Document (PDF)" />
                    <input @change="form.main_document = $event.target.files[0]" type="file" accept=".pdf"
                           class="mt-1 block w-full " />
                    <InputError class="mt-2" :message="form.errors.main_document" />
                </div>

                <div>
                    <InputLabel for="figures" value="Figures (optional)" />
                    <input multiple @change="form.figures = Array.from($event.target.files)" type="file" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.figures" />
                </div>

                <div>
                    <InputLabel for="supplementary" value="Supplementary Files (optional)" />
                    <input multiple @change="form.supplementary = Array.from($event.target.files)" type="file" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.supplementary" />
                </div>

                <div>
                    <InputLabel for="cover_letter" value="Cover Letter (PDF)" />
                    <input @change="form.cover_letter = $event.target.files[0]" type="file" accept=".pdf" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.cover_letter" />
                </div>
            </div>

            <!-- Declarations -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="ethical_approval" value="Ethical Approval Statement" />
                    <TextInput id="ethical_approval" v-model="form.ethical_approval" type="text"
                               class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" />
                    <InputError class="mt-2" :message="form.errors.ethical_approval" />
                </div>

                <div>
                    <InputLabel for="conflict_of_interest" value="Conflict of Interest" />
                    <TextInput id="conflict_of_interest" v-model="form.conflict_of_interest" type="text"
                               class="mt-1 block w-full block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600" />
                    <InputError class="mt-2" :message="form.errors.conflict_of_interest" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="funding_statement" value="Funding Statement" />
                    <textarea id="funding_statement" v-model="form.funding_statement" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300  block py-2.5 px-0 w-full text-sm text-gray-900 border-0 border-b-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600"></textarea>
                    <InputError class="mt-2" :message="form.errors.funding_statement" />
                </div>
            </div>

            <!-- Consent and Originality -->
            <div class="space-y-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" v-model="form.consent" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">I confirm all co-authors have consented to this submission.</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" v-model="form.originality" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">I declare that this manuscript is original and not under review elsewhere.</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit Manuscript
                </PrimaryButton>
            </div>

        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    title: '',
    abstract: '',
    keywords: '',
    article_type: '',
    affiliation: '',
    journal: '',
    subject_area: '',
    main_document: null,
    figures: [],
    supplementary: [],
    cover_letter: null,
    ethical_approval: '',
    conflict_of_interest: '',
    funding_statement: '',
    consent: false,
    originality: false,
})

const submit = () => {
    form.post('/author/submit-new-manuscript', {
        onFinish: () => {
            form.reset(); // Resets all fields to their initial value
            // Manually clear <input type="file"> fields if needed
            document.querySelectorAll('input').forEach(input => input.value = '');
        },
    });
};
</script>
