<template>
    <div>
        <SpanError :error="form.errors.error" class="mb-1" />
        <SpanSuccess :success="form.success" class="mb-1" />

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
            <NormalButton type="submit" label="Send Password Reset Link" :loading="loading" />
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
import { ref } from 'vue'

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

        const loading = ref(false)

        const forgotPassword = () => {
            loading.value = true
            form.post(route('forgot-password.store'), {
                preserveScroll: true,
                onSuccess: (response) => {
                    form.success = response.props.success
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
            forgotPassword,
            loading
        }
    }
}
</script>
