<template>
    <AuthenticatedLayout>
        <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Dashboard
            </h1>
            <p class="text-gray-700 dark:text-gray-300 mb-6 text-xl">
                Welcome to the dashboard, {{ user.name }}!
            </p>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'

export default {
    name: 'DashboardPage',
    components: {
        AuthenticatedLayout
    },
    setup() {
        const page = usePage()
        const user = computed(() => page.props.auth.user)

        return {
            user
        }
    }
}
</script>
