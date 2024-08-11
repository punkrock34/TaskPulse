<template>
    <SpanError :has-error="form.errors.error" :error="form.errors.error" />
    <SpanSuccess :has-success="form.success" :success="form.success" />

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
        <NormalButton type="submit" label="Reset Password" />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import PasswordStrengthIndicator from '@/components/common/PasswordStrengthIndicator.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'

export default {
    name: 'ResetPasswordForm',
    components: {
        PasswordInput,
        NormalButton,
        SpanError,
        SpanSuccess,
        PasswordStrengthIndicator
    },
    setup() {
        const form = useForm({
            password: '',
            password_confirmation: ''
        })

        const resetPassword = () => {
            form.post(route('reset-password.store', { token: route().params.token }), {
                preserveScroll: true
            })
        }

        return {
            form,
            resetPassword
        }
    }
}
</script>
