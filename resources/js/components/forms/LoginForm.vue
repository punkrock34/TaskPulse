<template>
    <SpanError :has-error="form.errors.error" :error="form.errors.error" />

    <form class="space-y-4" @submit.prevent="login">
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
        <PasswordInput
            id="password"
            v-model="form.password"
            label="Password"
            placeholder="••••••••"
            :required="true"
            :has-error="form.errors.password"
            :error="form.errors.password"
        />
        <CheckboxInput id="remember" v-model="form.remember" label="Remember me" />
        <a
            :href="forgotPasswordRoute"
            class="text-sm text-blue-700 hover:underline dark:text-blue-500"
        >
            Forgot password?
        </a>
        <SubmitButton label="Sign in" />
    </form>
</template>

<script>
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import PasswordInput from '@/components/inputs/PasswordInput.vue'
import CheckboxInput from '@/components/inputs/CheckboxInput.vue'
import SubmitButton from '@/components/buttons/SubmitButton.vue'
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'LoginForm',
    components: {
        TextInput,
        PasswordInput,
        CheckboxInput,
        SubmitButton,
        SpanError
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

        const login = () => {
            form.post(route('login'), {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            form,
            login
        }
    }
}
</script>
