<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="max-w-md mx-auto">
            <!-- Name -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="text"
                    name="name"
                    id="name"
                    v-model="form.name"
                    placeholder=" "
                    required
                    autofocus
                    autocomplete="name"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                />
                <label for="name"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Name
                </label>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="email"
                    name="email"
                    id="email"
                    v-model="form.email"
                    placeholder=" "
                    required
                    autocomplete="username"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                />
                <label for="email"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Email
                </label>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    v-model="form.password"
                    placeholder=" "
                    required
                    autocomplete="new-password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                />
                <label for="password"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Password
                </label>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Confirm Password -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    placeholder=" "
                    required
                    autocomplete="new-password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                />
                <label for="password_confirmation"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Confirm Password
                </label>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>


            <div class="mt-4">
                <InputLabel for="role" value="Select Role" />

                <select
                    id="role"
                    v-model="form.role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                    <option value="" disabled>Select a role</option>
                    <option value="author">Author</option>
                    <option value="reviewer">Reviewer</option>
                    <option value="editor">Editor</option>
                </select>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-between">
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-600 hover:underline dark:text-gray-400 dark:hover:text-white"
                >
                    Already registered?
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-25"
                >
                    Register
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

