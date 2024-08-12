<template>
    <AuthenticatedLayout>
        <div
            :class="[
                'p-6 sm:p-8 rounded-lg shadow-md theme-transition',
                task.status === 'completed'
                    ? 'bg-green-100 dark:bg-green-800'
                    : 'bg-white dark:bg-gray-800'
            ]"
        >
            <!-- Task Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ task.title }}</h1>
                <span :class="badgeClass" class="badge badge-outline px-4 py-2 text-lg">
                    {{ statusLabel }}
                </span>
            </div>

            <!-- Task Description -->
            <p class="text-gray-700 dark:text-gray-300 mb-6">{{ task.description }}</p>

            <!-- Task Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Task Details</h3>
                    <p>Created At: {{ createdAtFormatted }}</p>
                    <p>Deadline: {{ deadlineFormatted }}</p>
                    <p>Status: {{ statusLabel }}</p>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Assigned To</h3>
                    <p>{{ task.user.name }}</p>
                    <p>{{ task.user.email }}</p>
                </div>
            </div>

            <!-- Task Actions -->
            <div class="flex justify-end space-x-4">
                <button
                    :class="[
                        'btn btn-sm',
                        task.status === 'completed' ? 'btn-warning' : 'btn-success'
                    ]"
                    @click="toggleTaskCompletion"
                >
                    {{ task.status === 'completed' ? 'Mark as Incomplete' : 'Mark as Complete' }}
                </button>
                <button class="btn btn-sm btn-outline dark:btn-outline dark:btn-primary">
                    Edit Task
                </button>
                <button class="btn btn-sm btn-danger">Delete Task</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'
import { TaskStatus } from '@/enums/taskStatus.js'

export default {
    name: 'TaskDetails',
    components: {
        AuthenticatedLayout
    },
    setup() {
        const page = usePage()

        const task = computed(() => page.props.task)

        const createdAtFormatted = computed(() => {
            return new Date(task.value.created_at).toLocaleDateString()
        })

        const deadlineFormatted = computed(() => {
            return new Date(task.value.deadline).toLocaleDateString()
        })

        const statusLabel = computed(() => {
            switch (task.value.status) {
                case TaskStatus.TODO:
                    return 'To Do'
                case TaskStatus.IN_PROGRESS:
                    return 'In Progress'
                case TaskStatus.COMPLETED:
                    return 'Completed'
                default:
                    return 'Unknown'
            }
        })

        const badgeClass = computed(() => {
            switch (task.value.status) {
                case TaskStatus.TODO:
                    return 'badge-warning'
                case TaskStatus.IN_PROGRESS:
                    return 'badge-info'
                case TaskStatus.COMPLETED:
                    return 'badge-success'
                default:
                    return 'badge-ghost'
            }
        })

        const toggleTaskCompletion = () => {
            task.value.status =
                task.value.status === TaskStatus.COMPLETED ? TaskStatus.TODO : TaskStatus.COMPLETED
        }

        return {
            task,
            createdAtFormatted,
            deadlineFormatted,
            statusLabel,
            badgeClass,
            toggleTaskCompletion
        }
    }
}
</script>
