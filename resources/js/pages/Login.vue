<template>
    <DefaultLayout>
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-xl p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Welcome Back!
                </h1>
                <LoginForm :forgot-password-route="route('forgot-password.index')" />
                <div
                    class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300"
                >
                    <p
                        class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white text-xl"
                    >
                        Or
                    </p>
                </div>
                <ButtonWithIcon
                    label="Sign in with Google"
                    icon="https://www.svgrepo.com/show/355037/google.svg"
                    alt="Google logo"
                    type="button"
                    @click="signInWithGoogle"
                />
                <div class="mt-4 text-md font-medium text-gray-500 dark:text-gray-300 text-center">
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
import ButtonWithIcon from '@/components/buttons/ButtonWithIcon.vue'
import { auth, provider, signInWithPopup } from '@/firebase'
import axios from 'axios'

export default {
    name: 'LoginPage',
    components: {
        DefaultLayout,
        LoginForm,
        ButtonWithIcon
    },
    methods: {
        async signInWithGoogle() {
            console.log('Signing in with Google...')
            try {
                const result = await signInWithPopup(auth, provider)
                const idToken = await result.user.getIdToken()
                await axios.post(route('login.google.store'), { idToken: idToken })
                window.location.href = route('dashboard.index')
            } catch (error) {
                console.error('Google sign-in error', error)
                alert('Failed to sign in with Google. Please try again.')
            }
        },
        route
    }
}
</script>
