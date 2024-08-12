<template>
    <DefaultLayout>
        <SnackbarNotification ref="snackbarRef" />
        <div class="flex flex-grow items-center justify-center w-full">
            <div
                class="w-full max-w-xl p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
            >
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Forgot Password
                </h1>
                <ForgotPasswordForm />
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import DefaultLayout from '@/components/layouts/DefaultLayout.vue'
import ForgotPasswordForm from '@/components/forms/ForgotPasswordForm.vue'
import SnackbarNotification from '@/components/ui/SnackbarNotification.vue'

export default {
    name: 'ForgotPasswordPage',
    components: {
        DefaultLayout,
        ForgotPasswordForm,
        SnackbarNotification
    },
    setup() {
        const { props } = usePage()
        const snackbarRef = ref(null)

        onMounted(() => {
            if (props.errors.error) {
                snackbarRef.value.show(props.errors.error)
            }
        })

        return {
            snackbarRef
        }
    }
}
</script>
