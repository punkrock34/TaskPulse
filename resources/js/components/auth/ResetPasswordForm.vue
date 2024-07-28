<template>
    <div
        class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900"
    >
        <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Reset your password <span role="img" aria-label="key">🔑</span>
            </h1>

            <Alerts :status="statusMessage" :error="errorMessage" :errors="validationErrors" />

            <form class="space-y-4" @submit.prevent="resetPassword">
                <div :class="{ 'has-error': hasError('password') }">
                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Password <span role="img" aria-label="lock">🔒</span></label
                    >
                    <input
                        id="password"
                        v-model="password"
                        type="password"
                        placeholder="••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        required
                    />
                    <span v-if="hasError('password')" class="text-red-600 text-sm">{{
                        getError('password')
                    }}</span>
                </div>
                <div :class="{ 'has-error': hasError('password_confirmation') }">
                    <label
                        for="password_confirmation"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Confirm password <span role="img" aria-label="lock">🔒</span></label
                    >
                    <input
                        id="password_confirmation"
                        v-model="password_confirmation"
                        type="password"
                        placeholder="••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        required
                    />
                    <span v-if="hasError('password_confirmation')" class="text-red-600 text-sm">{{
                        getError('password_confirmation')
                    }}</span>
                </div>
                <button
                    type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Reset Password
                </button>
            </form>
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
            password: '',
            password_confirmation: ''
        }
    },
    methods: {
        resetPassword() {
            const code = this.$route.params.code
            this.resetUserPassword({
                password: this.password,
                password_confirmation: this.password_confirmation,
                code: code
            })
        }
    }
}
</script>
