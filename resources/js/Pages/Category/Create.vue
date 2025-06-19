<template xmlns="http://www.w3.org/1999/html">
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto mt-10 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-2xl shadow-lg p-6">

                <!-- FORM SECTION -->
                <div class="order-1 md:order-2">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Create New Category</h2>
                    <form @submit.prevent="submit" class="space-y-4">
                        <!-- Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input
                                v-model="form.name"
                                @input="generateSlug"
                                type="text"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                                placeholder="e.g., Health Sciences"
                            />
                            <span class="text-sm text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
                        </div>

                        <!-- Slug Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slug</label>
                            <input
                                v-model="form.slug"
                                type="text"
                                class="mt-1 block w-full border border-gray-200 rounded-md p-2 bg-gray-100 text-gray-600"
                                readonly
                            />
                        </div>
                        <!-- Parent Category Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Parent Category (Optional)</label>
                            <select
                                v-model="form.parent_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 bg-white"
                            >
                                <option :value="null">-- This is a Root Category --</option>
                                <option
                                    v-for="cat in formattedCategories"
                                    :key="cat.id"
                                    :value="cat.id"
                                >
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>



                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                v-model="form.description"
                                class="mt-1 block w-full border border-gray-200 rounded-md p-2 bg-gray-100 text-gray-600"
                                rows="4"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded shadow w-full"
                        >
                            {{ form.processing ? 'Submitting...' : 'Create Category' }}
                        </button>
                    </form>
                </div>

                <!-- EXISTING CATEGORIES SECTION -->
                <div class="order-2 md:order-1">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Existing Categories</h3>
                    <ul class="space-y-2">
                        <li
                            v-for="(cat, index) in nestedCategories"
                            :key="index"
                            class="bg-gray-50 border border-gray-200 rounded-md p-3"
                        >
                            <ExistingCategories
                                :category="cat"
                            />

                        </li>
                    </ul>

                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<script setup>
import {onMounted, reactive, ref} from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

let props = defineProps({
    categories: Array
})
const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: null,
})
import { computed } from 'vue';
import ExistingCategories from "@/Components/ExistingCategories.vue";

// Example categories array (replace with prop or backend response as needed)
const displayedCategories = ref([])
let nestedCategories = ref([])
displayedCategories.value = props.categories


function buildTree(categories, parentId = null) {
    return categories
        .filter(cat => cat.parent_id === parentId)
        .map(cat => ({
            ...cat,
            subcategories: buildTree(categories, cat.id)
        }));
}

nestedCategories.value = buildTree(displayedCategories.value);

// Generate slug automatically
function generateSlug() {
    form.slug = form.name
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')       // Remove special characters
        .trim()
        .replace(/\s+/g, '-')           // Replace spaces with dashes
}

// Submit function
function submit() {
    // Send to backend
axios.post('/editor/categories/create', form)
    .then(res =>{
        displayedCategories.value = res.data.categories
        nestedCategories.value = buildTree(displayedCategories.value)
            form.name = '';
            form.slug = '';
            form.description = '';
            form.parent_id = null;
    })

}
const buildCategoryTree = (categories, parentId = null, depth = 0) => {
    return categories
        .filter(cat => cat.parent_id === parentId)
        .flatMap(cat => {
            const indent = '—'.repeat(depth);
            return [
                { id: cat.id, name: `${indent} ${cat.name}`.trim() },
                ...buildCategoryTree(categories, cat.id, depth + 1)
            ];
        });
};

// Computed: use formattedCategories in the template
const formattedCategories = computed(() => buildCategoryTree(displayedCategories.value));

</script>
