<template>
    <div>
        <SpanError :has-error="errors.error" :error="errors.error" class="mb-1" />
        <SpanWithActionLink
            v-show="errors.resend_verification"
            class="mb-1"
            :has-action-link="errors.resend_verification"
            :pre-action-text="'Please verify your email address. If you did not receive the email, you can'"
            :action-text="'Resend verification email'"
            :post-action-text="'.'"
            :has-post-action-text="true"
            :action-link="resendVerificationEmail"
        />
        <SpanSuccess :has-success="success" :success="success" />

        <form class="space-y-4" @submit.prevent="resendVerificationEmail">
            <TextInput
                id="email"
                v-model="email"
                label="Email Address"
                type="email"
                placeholder="name@company.com"
                :required="true"
                :has-error="errors.email"
                :error="errors.email"
            />
            <NormalButton type="submit" label="Resend Verification Email" />
        </form>
    </div>
</template>

<script>
import { ref } from 'vue'
import { route } from 'ziggy-js'
import TextInput from '@/components/inputs/TextInput.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import SpanWithActionLink from '@/components/common/SpanWithActionLink.vue'
import axios from 'axios'

export default {
    name: 'VerifyEmailForm',
    components: {
        TextInput,
        NormalButton,
        SpanError,
        SpanSuccess,
        SpanWithActionLink
    },
    setup() {
        const email = ref('')
        const errors = ref({})
        const success = ref('')

        const resendVerificationEmail = async () => {
            try {
                const response = await axios.post(route('verification.store'), {
                    email: email.value
                })
                errors.value = {}
                success.value = response.data.message
            } catch (error) {
                errors.value = { email: error.response.data.message }
            }
        }

        return {
            email,
            errors,
            success,
            resendVerificationEmail
        }
    }
}
</script>
