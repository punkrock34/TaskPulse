<template>
    <DefaultLayout>
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-xl p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Reset Password
                </h1>
                <ResetPasswordForm />
            </div>
        </div>
    </DefaultLayout>
</template>
<script>
import DefaultLayout from '@/components/layouts/DefaultLayout.vue'
import ResetPasswordForm from '@/components/forms/ResetPasswordForm.vue'

export default {
    name: 'ResetPasswordPage',
    components: {
        DefaultLayout,
        ResetPasswordForm
    }
}
</script>
