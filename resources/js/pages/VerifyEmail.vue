<template>
    <DefaultLayout>
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-xl p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Verify Email
                </h1>
                <SpanSuccess
                    v-if="status === 'success'"
                    class="text-center"
                    :has-success="true"
                    :success="'Your email has been verified. You can now login.'"
                />
                <SpanError
                    v-else-if="status === 'already_verified'"
                    class="text-center"
                    :has-error="true"
                    :error="'Your email has already been verified. If you did not receive the email, you can request a new one below.'"
                />
                <SpanError v-else :has-error="true" :error="message" class="text-center" />
                <div v-if="showForm" class="mt-6">
                    <VerifyEmailForm />
                </div>
                <div class="mt-6 text-center">
                    <a :href="route('login.index')" class="text-blue-500 hover:underline">
                        Return to Login
                    </a>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import { route } from 'ziggy-js'
import DefaultLayout from '@/components/layouts/DefaultLayout.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import SpanError from '@/components/common/SpanError.vue'
import VerifyEmailForm from '@/components/forms/VerifyEmailForm.vue'

export default {
    name: 'VerifyEmail',
    components: {
        DefaultLayout,
        SpanSuccess,
        SpanError,
        VerifyEmailForm
    },
    props: {
        status: {
            type: String,
            required: true
        },
        message: {
            type: String,
            default: ''
        }
    },
    computed: {
        showForm() {
            return this.status === 'already_verified'
        }
    },
    methods: {
        route
    }
}
</script>
