<template>
    <SpanError :error="form.errors.error" class="mb-1" />
    <SpanWithActionLink
        v-show="form.errors.email_not_verified"
        class="mb-1"
        :pre-action-text="'Please verify your email address. If you did not receive the email, you can'"
        :action-text="'Resend verification email'"
        :action-link="resendVerificationEmail"
    />
    <SpanSuccess :success="form.success" class="mb-1" />

    <form class="space-y-4" @submit.prevent="login">
        <TextInput
            id="email"
            v-model="form.email"
            label="Email Address"
            type="email"
            placeholder="name@company.com"
            :required="true"
            :error="form.errors.email"
        />
        <PasswordInput
            id="password"
            v-model="form.password"
            label="Password"
            placeholder="••••••••"
            :required="true"
            :error="form.errors.password"
        />
        <CheckboxInput id="remember" v-model="form.remember" label="Remember me" />
        <a
            :href="forgotPasswordRoute"
            class="text-sm text-blue-700 hover:underline dark:text-blue-500"
        >
            Forgot password?
        </a>
        <NormalButton
            type="submit"
            label="Sign In"
            :loading="loading"
            :custom-class="'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white'"
        />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import CheckboxInput from '@/components/inputs/CheckboxInput.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import SpanWithActionLink from '@/components/common/SpanWithActionLink.vue'
import axios from 'axios'
import { ref } from 'vue'

export default {
    name: 'LoginForm',
    components: {
        TextInput,
        PasswordInput,
        CheckboxInput,
        NormalButton,
        SpanError,
        SpanSuccess,
        SpanWithActionLink
    },
    props: {
        forgotPasswordRoute: {
            type: String,
            required: true
        }
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
            remember: false
        })

        const loading = ref(false)

        const login = () => {
            loading.value = true
            form.post(route('login.store'), {
                preserveScroll: true,
                onError: (errors) => {
                    form.errors.error = errors.error
                    if (errors.email_not_verified) {
                        form.errors.email_not_verified = true
                    }
                },
                onFinish: () => (loading.value = false)
            })
        }

        const resendVerificationEmail = async () => {
            try {
                const response = await axios.post(route('verification.store'), {
                    email: form.email
                })
                form.errors.email_not_verified = false
                form.success = response.data.message
                form.errors.error = ''
            } catch (error) {
                form.errors.email_not_verified = true
                form.errors.error = error.response.data.message
                form.success = ''
            }
        }

        return {
            form,
            login,
            resendVerificationEmail,
            loading
        }
    }
}
</script>
