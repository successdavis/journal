<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: url('/images/bg-image.png')">
            <div class="absolute inset-0 bg-blue-600 bg-opacity-80 z-0"></div>

            <div class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-8 rounded-xl shadow-lg w-full max-w-lg">
                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Login to Your Account</h2>

                <form @submit.prevent="submit">
                    <!-- Email -->
                    <div class="relative z-0 w-full mb-5 group">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            v-model="form.email"
                            placeholder=" "
                            required
                            autofocus
                            autocomplete="username"
                            class="input-field peer"
                        />
                        <label for="email" class="input-label peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-blue-600 peer-focus:dark:text-blue-500">
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
                            autocomplete="current-password"
                            class="input-field peer"
                        />
                        <label for="password" class="input-label peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-blue-600 peer-focus:dark:text-blue-500">
                            Password
                        </label>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mb-4 text-sm text-gray-700 dark:text-gray-300">
                        <input
                            id="remember"
                            type="checkbox"
                            v-model="form.remember"
                            class="mr-2"
                        />
                        <label for="remember">Remember me</label>
                    </div>

                    <!-- Submit -->
                    <div class="mt-6">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full text-white font-medium py-2.5 px-5 rounded-lg bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-400 hover:opacity-90 transition disabled:opacity-50"
                        >
                            SIGN IN
                        </button>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 text-sm text-center text-gray-600 dark:text-gray-300">
                        Don’t have an account?
                        <Link :href="route('register')" class="text-blue-600 font-semibold hover:underline">Register here</Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.input-field {
    @apply block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 dark:text-white dark:border-gray-400 dark:focus:border-blue-500;
}

.input-label {
    @apply absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0];
}
</style>
