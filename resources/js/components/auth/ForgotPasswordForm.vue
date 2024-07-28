<template>
    <div
        class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900"
    >
        <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Password Reset <span role="img" aria-label="key">🔑</span>
            </h1>

            <Alerts :status="statusMessage" :error="errorMessage" :errors="validationErrors" />

            <form class="space-y-4" @submit.prevent="requestPasswordReset">
                <div :class="{ 'has-error': hasError('email') }">
                    <label
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your email <span role="img" aria-label="envelope">📧</span></label
                    >
                    <input
                        id="email"
                        v-model="email"
                        type="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="name@company.com"
                        required
                    />
                    <span v-if="hasError('email')" class="text-red-600 text-sm">{{
                        getError('email')
                    }}</span>
                </div>
                <button
                    type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Send reset link
                </button>
            </form>

            <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
                Remembered your password?
                <router-link to="/" class="text-blue-700 hover:underline dark:text-blue-500"
                    >Log in <span role="img" aria-label="arrow">➡️</span></router-link
                >
            </div>
        </div>
    </div>
</template>

<script>
import Alerts from '@/components/AppAlerts.vue'
import authMixin from '@/mixins/authMixin'

export default {
    components: {
        Alerts
    },
    mixins: [authMixin],
    data() {
        return {
            email: '',
            statusMessage: window.Laravel.statusMessage || '',
            errorMessage: window.Laravel.errorMessage || '',
            validationErrors: window.Laravel.errors || []
        }
    },
    methods: {
        requestPasswordReset() {
            this.requestPasswordResetEmail({ email: this.email })
        }
    }
}
</script>
