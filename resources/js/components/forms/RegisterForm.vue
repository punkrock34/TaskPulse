<template>
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
            @input="checkPasswordStrength"
        />
        <PasswordInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            label="Confirm Password"
            placeholder="••••••••"
            :has-error="form.errors.password_confirmation"
            :error="form.errors.password_confirmation"
        />
        <!-- Password strength indicator -->
        <div class="relative">
            <div class="h-2 w-full bg-gray-300 rounded-full mt-1">
                <div
                    :class="passwordStrengthClass"
                    :style="{ width: passwordStrength + '%' }"
                    class="h-full rounded-full transition-all duration-300"
                ></div>
            </div>
            <p v-if="passwordStrengthMessage" class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                {{ passwordStrengthMessage }}
            </p>
        </div>
        <CheckboxInput
            id="terms"
            v-model="form.terms"
            label="I agree to the terms and conditions"
            :has-error="form.errors.terms"
            :error="form.errors.terms"
        />
        <SubmitButton label="Sign up" @click.prevent="register" />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import CheckboxInput from '@/components/inputs/CheckboxInput.vue'
import SubmitButton from '@/components/buttons/SubmitButton.vue'

export default {
    name: 'RegisterForm',
    components: {
        TextInput,
        PasswordInput,
        CheckboxInput,
        SubmitButton
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
            form.post(route('register'), {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset()
                },
                onError: (errors) => {
                    console.log(errors)
                }
            })
        }

        return {
            form,
            register
        }
    },
    data() {
        return {
            passwordStrength: 0,
            passwordStrengthClass: 'bg-red-500',
            passwordStrengthMessage: 'Weak'
        }
    },
    methods: {
        checkPasswordStrength() {
            const password = this.form.password
            let strength = 0

            if (password.length >= 8) strength += 1
            if (password.length >= 12) strength += 1
            if (password.match(/[A-Z]/)) strength += 1
            if (password.match(/[a-z]/)) strength += 1
            if (password.match(/[0-9]/)) strength += 1
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1

            this.passwordStrength = (strength / 6) * 100

            if (strength <= 2) {
                this.passwordStrengthClass = 'bg-red-500'
                this.passwordStrengthMessage = 'Weak'
            } else if (strength <= 4) {
                this.passwordStrengthClass = 'bg-yellow-500'
                this.passwordStrengthMessage = 'Moderate'
            } else {
                this.passwordStrengthClass = 'bg-green-500'
                this.passwordStrengthMessage = 'Strong'
            }
        }
    }
}
</script>
