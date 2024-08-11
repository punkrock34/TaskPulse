<template>
    <DefaultLayout>
        <SnackbarNotification ref="snackbarNotification" />
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-xl p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Sign up for an account
                </h1>
                <RegisterForm />
                <div
                    class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300"
                >
                    <p class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white">
                        Or
                    </p>
                </div>
                <ButtonWithIcon
                    label="Sign up with Google"
                    icon="https://www.svgrepo.com/show/355037/google.svg"
                    alt="Google logo"
                    type="button"
                    @click="signInWithGoogle"
                />
                <div class="mt-4 text-md font-medium text-gray-500 dark:text-gray-300 text-center">
                    Already have an account?
                    <a
                        :href="route('login.index')"
                        class="text-blue-700 hover:underline dark:text-blue-500"
                    >
                        Log in
                    </a>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import { route } from 'ziggy-js'
import DefaultLayout from '@/components/layouts/DefaultLayout.vue'
import RegisterForm from '@/components/forms/RegisterForm.vue'
import ButtonWithIcon from '@/components/buttons/ButtonWithIcon.vue'
import { auth, provider, signInWithPopup } from '@/firebase'
import axios from 'axios'
import SnackbarNotification from '@/components/ui/SnackbarNotification.vue'

export default {
    name: 'RegisterPage',
    components: {
        DefaultLayout,
        RegisterForm,
        ButtonWithIcon,
        SnackbarNotification
    },
    methods: {
        async signInWithGoogle() {
            try {
                const result = await signInWithPopup(auth, provider)
                const idToken = await result.user.getIdToken()
                await axios.post(route('login.google.store'), { idToken: idToken })
                window.location.href = route('dashboard.index')
            } catch (error) {
                this.$refs.snackbarNotification.show(
                    'Failed to sign in with Google. Please try again.'
                )
            }
        },
        route
    }
}
</script>
