<template>
    <SpanError :has-error="form.errors.error" :error="form.errors.error" />

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
        <NormalButton type="submit" label="Sign up" @click.prevent="register" />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import CheckboxInput from '@/components/inputs/CheckboxInput.vue'
import SpanError from '@/components/common/SpanError.vue'
import PasswordStrengthIndicator from '@/components/common/PasswordStrengthIndicator.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'

export default {
    name: 'RegisterForm',
    components: {
        TextInput,
        PasswordInput,
        CheckboxInput,
        NormalButton,
        SpanError,
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

        const register = () => {
            form.post(route('register.store'), {
                preserveScroll: true
            })
        }

        return {
            form,
            register
        }
    }
}
</script>
