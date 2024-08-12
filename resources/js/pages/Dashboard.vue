<template>
    <AuthenticatedLayout>
        <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Dashboard
            </h1>
            <p class="text-gray-700 dark:text-gray-300 mb-6 text-xl">
                Welcome to the dashboard, {{ user.name }}!
            </p>

            <!-- Loading Indicator -->
            <div v-if="loading" class="text-center">
                <LoadingIndicator :show-label="true" label="Loading tasks..." size="md" />
            </div>

            <!-- List of Tasks -->
            <div v-else-if="tasks.length > 0" class="task-list">
                <TaskComponent v-for="task in tasks" :key="task.id" :task="task" />
            </div>

            <!-- No Tasks Available -->
            <div v-else class="text-gray-500 dark:text-gray-400 text-center">
                No tasks available
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { route } from 'ziggy-js'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'
import TaskComponent from '@/components/ui/TaskComponent.vue'
import LoadingIndicator from '@/components/common/LoadingIndicator.vue'

export default {
    name: 'DashboardPage',
    components: {
        AuthenticatedLayout,
        TaskComponent,
        LoadingIndicator
    },
    setup() {
        const page = usePage()
        const user = computed(() => page.props.auth.user)

        const tasks = ref([])
        const loading = ref(false)

        const fetchTasks = async () => {
            loading.value = true
            try {
                // Simulate a delay to avoid awkwardly fast loading
                const timeStart = performance.now()
                const response = await axios.get(route('tasks.index'))
                const timeEnd = performance.now()

                if (timeEnd - timeStart < 1000) {
                    await new Promise((resolve) =>
                        setTimeout(resolve, 1000 - (timeEnd - timeStart))
                    )
                }

                tasks.value = response.data
            } catch (error) {
                console.error('There was an error fetching tasks', error)
            } finally {
                loading.value = false
            }
        }

        onMounted(() => {
            fetchTasks()
        })

        return {
            user,
            tasks,
            loading
        }
    }
}
</script>
