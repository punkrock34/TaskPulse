<template>
    <div :class="borderClass" class="card w-full shadow-md mb-4 transition-all duration-300">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title text-lg font-semibold">
                    {{ task.title }}
                </h2>
                <span :class="badgeClass" class="badge badge-outline">{{ statusLabel }}</span>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ task.description }}</p>
            <div v-if="task.deadline" class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                <span>Deadline: {{ deadlineFormatted }}</span>
            </div>
            <div v-else class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                <span>No deadline set</span>
            </div>
            <div class="card-actions justify-end mt-4">
                <a :href="route('tasks.show', { id: task.id })" class="btn btn-sm btn-primary">
                    View Details
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { route } from 'ziggy-js'
import { TaskStatus } from '@/enums/taskStatus'

export default {
    name: 'TaskComponent',
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const deadlineFormatted = computed(() => {
            return new Date(props.task.deadline).toLocaleDateString()
        })

        const statusLabel = computed(() => {
            switch (props.task.status) {
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

        const borderClass = computed(() => {
            switch (props.task.status) {
                case TaskStatus.TODO:
                    return 'border-l-4 border-yellow-400'
                case TaskStatus.IN_PROGRESS:
                    return 'border-l-4 border-blue-400'
                case TaskStatus.COMPLETED:
                    return 'border-l-4 border-green-400'
                default:
                    return 'border-l-4 border-gray-400'
            }
        })

        const badgeClass = computed(() => {
            switch (props.task.status) {
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

        return {
            deadlineFormatted,
            statusLabel,
            borderClass,
            badgeClass,
            route
        }
    }
}
</script>

<style scoped>
.card {
    background-color: var(--card-bg);
    color: var(--card-text);
}

.dark .card {
    background-color: var(--dark-card-bg);
    color: var(--dark-card-text);
}
</style>
