<template>
    <DefaultLayout>
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Welcome Back!
                </h1>
                <LoginForm :forgot-password-route="route('forgot-password.index')" />
                <div
                    class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300"
                >
                    <p class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white">
                        Or
                    </p>
                </div>
                <SocialButton
                    label="Sign in with Google"
                    icon="https://www.svgrepo.com/show/355037/google.svg"
                    alt="Google logo"
                    :on-click="signInWithGoogle"
                />
                <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
                    Not registered?
                    <a
                        :href="route('register.index')"
                        class="text-blue-700 hover:underline dark:text-blue-500"
                    >
                        Create account
                    </a>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import { route } from 'ziggy-js'
import DefaultLayout from '@/components/layouts/DefaultLayout.vue'
import LoginForm from '@/components/forms/LoginForm.vue'
import SocialButton from '@/components/buttons/SocialButton.vue'

export default {
    name: 'LoginPage',
    components: {
        DefaultLayout,
        LoginForm,
        SocialButton
    },
    methods: {
        signInWithGoogle() {
            // Implement Google sign-in logic
        },
        route
    }
}
</script>
