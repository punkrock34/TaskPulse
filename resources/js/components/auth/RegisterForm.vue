<template>
    <div
        class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900"
    >
        <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Sign up for an account <span role="img" aria-label="sparkles">✨</span>
            </h1>

            <Alerts :status="statusMessage" :error="errorMessage" :errors="validationErrors" />

            <form class="space-y-4" @submit.prevent="register">
                <div :class="{ 'has-error': hasError('name') }">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your name <span role="img" aria-label="writing hand">✍️</span></label
                    >
                    <input
                        id="name"
                        v-model="name"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="John Doe"
                        required
                    />
                    <span v-if="hasError('name')" class="text-red-600 text-sm">{{
                        getError('name')
                    }}</span>
                </div>
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
                <div :class="{ 'has-error': hasError('password') }" class="relative">
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
                        @input="checkPasswordStrength"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none dark:text-gray-500 -bottom-7"
                        @click="togglePasswordVisibility"
                    >
                        <i :class="passwordVisible ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                    <span v-if="hasError('password')" class="text-red-600 text-sm">{{
                        getError('password')
                    }}</span>
                </div>
                <div :class="{ 'has-error': hasError('password_confirmation') }" class="relative">
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
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none dark:text-gray-500 -bottom-7"
                        @click="togglePasswordConfirmationVisibility"
                    >
                        <i
                            :class="passwordConfirmationVisible ? 'fas fa-eye-slash' : 'fas fa-eye'"
                        ></i>
                    </button>
                    <span v-if="hasError('password_confirmation')" class="text-red-600 text-sm">{{
                        getError('password_confirmation')
                    }}</span>
                </div>
                <!-- Password strength indicator -->
                <div class="relative">
                    <div class="h-2 w-full bg-gray-300 rounded-full mt-1">
                        <div
                            :class="passwordStrengthClass"
                            :style="{ width: passwordStrength + '%' }"
                            class="h-full rounded-full transition-all duration-300"
                        ></div>
                    </div>
                    <p
                        v-if="passwordStrengthMessage"
                        class="text-xs text-gray-600 dark:text-gray-400 mt-1"
                    >
                        {{ passwordStrengthMessage }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items">
                            <input
                                id="terms"
                                v-model="terms"
                                type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                required
                            />
                        </div>
                        <label
                            for="terms"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >I agree to the
                            <a href="#" class="text-blue-700 hover:underline dark:text-blue-500"
                                >terms and conditions</a
                            ></label
                        >
                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Sign up
                </button>
            </form>

            <div
                class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300"
            >
                <p class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white">Or</p>
            </div>

            <button
                type="button"
                class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                @click="signUpWithGoogle"
            >
                <div class="flex items-center justify-center">
                    <img
                        class="h-5 w-5 mr-2"
                        src="https://www.svgrepo.com/show/355037/google.svg"
                        alt="Google logo"
                    />
                    <span>Sign up with Google <span role="img" aria-label="google">🔍</span></span>
                </div>
            </button>

            <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
                Already have an account?
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
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false,
            passwordVisible: false,
            passwordConfirmationVisible: false,
            passwordStrength: 0,
            passwordStrengthMessage: '',
            passwordStrengthClass: ''
        }
    },
    methods: {
        register() {
            this.registerUser({
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                terms: this.terms
            })
        },
        togglePasswordVisibility() {
            this.passwordVisible = !this.passwordVisible
            document.getElementById('password').type = this.passwordVisible ? 'text' : 'password'
        },
        togglePasswordConfirmationVisibility() {
            this.passwordConfirmationVisible = !this.passwordConfirmationVisible
            document.getElementById('password_confirmation').type = this.passwordConfirmationVisible
                ? 'text'
                : 'password'
        },
        checkPasswordStrength() {
            const password = this.password
            let strength = 0
            let message = ''
            let strengthClass = ''

            if (password.length >= 8) strength += 1
            if (/[A-Z]/.test(password)) strength += 1
            if (/[a-z]/.test(password)) strength += 1
            if (/[0-9]/.test(password)) strength += 1
            if (/[^A-Za-z0-9]/.test(password)) strength += 1

            switch (strength) {
                case 1:
                    message = 'Very Weak'
                    strengthClass = 'bg-red-500'
                    break
                case 2:
                    message = 'Weak'
                    strengthClass = 'bg-yellow-500'
                    break
                case 3:
                    message = 'Moderate'
                    strengthClass = 'bg-yellow-400'
                    break
                case 4:
                    message = 'Strong'
                    strengthClass = 'bg-green-400'
                    break
                case 5:
                    message = 'Very Strong'
                    strengthClass = 'bg-green-500'
                    break
                default:
                    message = ''
                    strengthClass = ''
            }

            this.passwordStrength = (strength / 5) * 100
            this.passwordStrengthMessage = message
            this.passwordStrengthClass = strengthClass
        },
        signUpWithGoogle() {
            // Handle Google sign-up
        }
    }
}
</script>
