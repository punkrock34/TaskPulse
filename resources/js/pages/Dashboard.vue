<template>
    <AuthenticatedLayout>
        <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Dashboard
            </h1>
            <p class="text-gray-700 dark:text-gray-300 mb-6 text-xl">
                Welcome to the dashboard, {{ user.name }}!
            </p>

            <!-- List of Tasks -->
            <div v-if="tasks.length > 0" class="task-list">
                <TaskComponent v-for="task in tasks" :key="task.id" :task="task" />
            </div>
            <div v-else class="text-gray-500 dark:text-gray-400 text-center">
                No tasks available
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useStore } from 'vuex'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'
import TaskComponent from '@/components/ui/TaskComponent.vue'

export default {
    name: 'DashboardPage',
    components: {
        AuthenticatedLayout,
        TaskComponent
    },
    setup() {
        const page = usePage()
        const user = computed(() => page.props.auth.user)

        const store = useStore()

        const tasks = computed(() => store.state.tasks.tasks)

        return {
            user,
            tasks
        }
    }
}
</script>
