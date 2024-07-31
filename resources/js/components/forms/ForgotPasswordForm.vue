<template>
    <form class="space-y-4" @submit.prevent="forgotPassword">
        <TextInput
            id="email"
            v-model="form.email"
            label="Email Address"
            type="email"
            placeholder="name@company.com"
            :required="true"
            :has-error="form.errors.email"
            :error="form.errors.email"
        />
        <SubmitButton label="Send Password Reset Link" />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import SubmitButton from '@/components/buttons/SubmitButton.vue'

export default {
    name: 'ForgotPasswordForm',
    components: {
        TextInput,
        SubmitButton
    },
    setup() {
        const form = useForm({
            email: ''
        })

        const forgotPassword = () => {
            form.post(route('forgot-password'), {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            form,
            forgotPassword
        }
    }
}
</script>
