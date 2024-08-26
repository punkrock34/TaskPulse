<template>
    <SpanError :has-error="form.errors.error" :error="form.errors.error" class="mb-1" />
    <SpanWithActionLink
        v-show="form.success"
        class="mb-1"
        :pre-action-text="'Password reset successfully. You can now'"
        :action-text="'Sign in'"
        :action-link="loginRoute"
        :is-success="true"
    />

    <form class="space-y-4" @submit.prevent="resetPassword">
        <PasswordInput
            id="password"
            v-model="form.password"
            label="New Password"
            placeholder="••••••••"
            :has-error="form.errors.password"
            :error="form.errors.password"
        />
        <PasswordInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            label="Confirm Password"
            placeholder="••••••••"
            :has-error="form.errors.password_confirmation"
            :error="form.errors.password_confirmation"
        />
        <PasswordStrengthIndicator :password="form.password" />
        <NormalButton
            type="submit"
            label="Reset Password"
            :loading="loading"
            :custom-class="'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white'"
        />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanWithActionLink from '@/components/common/SpanWithActionLink.vue'
import PasswordStrengthIndicator from '@/components/common/PasswordStrengthIndicator.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import { ref } from 'vue'

export default {
    name: 'ResetPasswordForm',
    components: {
        PasswordInput,
        NormalButton,
        SpanError,
        SpanWithActionLink,
        PasswordStrengthIndicator
    },
    setup() {
        const form = useForm({
            password: '',
            password_confirmation: ''
        })

        const loading = ref(false)
        const loginRoute = () => {
            window.location.href = route('login.index')
        }

        const resetPassword = () => {
            loading.value = true
            form.post(route('reset-password.store', { token: route().params.token }), {
                preserveScroll: true,
                onSuccess: (response) => {
                    form.success = response.props.success
                    form.reset()
                },
                onError: (errors) => {
                    form.errors.error = errors.error
                    if (errors.email_not_verified) {
                        form.errors.email_not_verified = true
                    }
                },
                onFinish: () => (loading.value = false)
            })
        }

        return {
            form,
            resetPassword,
            loading,
            loginRoute
        }
    }
}
</script>
