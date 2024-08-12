<template>
    <AuthenticatedLayout>
        <div
            :class="[
                'p-6 sm:p-8 rounded-lg shadow-md theme-transition',
                task.completed ? 'bg-green-100 dark:bg-green-800' : 'bg-white dark:bg-gray-800'
            ]"
        >
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">{{ task.title }}</h1>
            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ task.description }}</p>
            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span>Created At: {{ createdAtFormatted }}</span>
                <br />
                <span>Deadline: {{ deadlineFormatted }}</span>
                <br />
                <span>Status: {{ task.completed ? 'Completed' : 'Incomplete' }}</span>
            </div>
            <div class="flex justify-end">
                <button
                    :class="[
                        'btn btn-sm',
                        task.completed
                            ? 'btn-success'
                            : 'btn-outline dark:btn-outline dark:btn-primary text-gray-900 dark:text-white'
                    ]"
                    @click="toggleTaskCompletion"
                >
                    {{ task.completed ? 'Mark as Incomplete' : 'Mark as Complete' }}
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'

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

        const toggleTaskCompletion = () => {
            task.value.completed = !task.value.completed
        }

        return {
            task,
            createdAtFormatted,
            deadlineFormatted,
            toggleTaskCompletion
        }
    }
}
</script>
