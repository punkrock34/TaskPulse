<template>
    <div>
        <SpanError :error="form.errors.error" class="mb-1" />
        <SpanWithActionLink
            v-show="form.errors.email_already_in_use"
            class="mb-1"
            :pre-action-text="'The email address is already in use. Please try logging in instead or'"
            :action-text="'Reset your password'"
            :action-link="forgotPassword"
        />
        <form class="space-y-4" @submit.prevent="register">
            <TextInput
                id="name"
                v-model="form.name"
                label="Name"
                type="text"
                placeholder="John Doe"
                :has-error="form.errors.name"
                :error="form.errors.name"
            />
            <TextInput
                id="email"
                v-model="form.email"
                label="Email Address"
                type="email"
                placeholder="name@company.com"
                :has-error="form.errors.email"
                :error="form.errors.email"
            />
            <PasswordInput
                id="password"
                v-model="form.password"
                label="Password"
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
            <CheckboxInput
                id="terms"
                v-model="form.terms"
                label="I agree to the terms and conditions"
                :has-error="form.errors.terms"
                :error="form.errors.terms"
            />
            <NormalButton
                type="submit"
                label="Sign up"
                :loading="loading"
                :custom-class="'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white'"
            />
        </form>
    </div>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import CheckboxInput from '@/components/inputs/CheckboxInput.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanWithActionLink from '@/components/common/SpanWithActionLink.vue'
import PasswordStrengthIndicator from '@/components/common/PasswordStrengthIndicator.vue'
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    name: 'RegisterForm',
    components: {
        TextInput,
        PasswordInput,
        CheckboxInput,
        NormalButton,
        SpanError,
        SpanWithActionLink,
        PasswordStrengthIndicator
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false
        })

        const loading = ref(false)

        const register = () => {
            loading.value = true
            form.post(route('register.store'), {
                preserveScroll: true,
                onError: (errors) => {
                    form.errors.error = errors.error
                    if (errors.email_already_in_use) {
                        form.errors.email_already_in_use = true
                    }
                },
                onFinish: () => (loading.value = false)
            })
        }

        const forgotPassword = async () => {
            Inertia.visit(route('forgot-password.index'))
        }

        return {
            form,
            register,
            forgotPassword,
            loading
        }
    }
}
</script>
