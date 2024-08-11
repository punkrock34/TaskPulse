<template>
    <div>
        <SpanError :error="form.errors.error" />
        <SpanSuccess :success="form.success" />

        <form class="space-y-4" @submit.prevent="forgotPassword">
            <TextInput
                id="email"
                v-model="form.email"
                label="Email Address"
                type="email"
                placeholder="name@company.com"
                :required="true"
                :error="form.errors.email"
            />
            <NormalButton type="submit" label="Send Password Reset Link" />
        </form>
    </div>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'

export default {
    name: 'ForgotPasswordForm',
    components: {
        TextInput,
        NormalButton,
        SpanError,
        SpanSuccess
    },
    setup() {
        const form = useForm({
            email: ''
        })

        const forgotPassword = () => {
            form.post(route('forgot-password.store'), {
                preserveScroll: true
            })
        }

        return {
            form,
            forgotPassword
        }
    }
}
</script>
