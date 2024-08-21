<template>
    <div :class="[borderClass, 'card w-full shadow-md mb-4 theme-transition']">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <h2 class="card-title text-lg font-semibold text-gray-900 dark:text-white">
                    {{ task.title }}
                </h2>
                <span :class="badgeClass" class="badge badge-outline">{{ statusLabel }}</span>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ task.description }}</p>

            <div class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                <span>Time Remaining: </span>
                <span :class="timeRemainingClass">{{ timeRemaining }}</span>
            </div>

            <div v-if="task.priority" class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                <span>Priority: </span>
                <span :class="priorityClass">{{ priorityLabel }}</span>
            </div>

            <div class="card-actions justify-end mt-4">
                <LinkButton
                    :href="route('task.index', { id: task.id })"
                    label="View Details"
                    type="button"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { route } from 'ziggy-js'
import LinkButton from '@/components/buttons/LinkButton.vue'

export default {
    name: 'TaskComponent',
    components: {
        LinkButton
    },
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const timeRemaining = computed(() => {
            if (!props.task.deadline) return 'No Deadline'

            const deadline = new Date(props.task.deadline)
            const now = new Date()
            const diff = deadline - now

            if (diff < 0) {
                return 'Overdue'
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24))
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))

            return `${days}d ${hours}h ${minutes}m`
        })

        const timeRemainingClass = computed(() => {
            if (!props.task.deadline) return ''
            const deadline = new Date(props.task.deadline)
            const now = new Date()
            const diff = deadline - now

            if (diff < 0) return 'text-red-500'
            if (diff < 1000 * 60 * 60 * 24 * 2) return 'text-yellow-500'
            return 'text-green-500'
        })

        const statusLabel = computed(() => {
            switch (props.task.status) {
                case 'TODO':
                    return 'To Do'
                case 'IN_PROGRESS':
                    return 'In Progress'
                case 'COMPLETED':
                    return 'Completed'
                default:
                    return 'Unknown'
            }
        })

        const priorityLabel = computed(() => {
            switch (props.task.priority) {
                case 'LOW':
                    return 'Low'
                case 'MEDIUM':
                    return 'Medium'
                case 'HIGH':
                    return 'High'
                default:
                    return 'Unknown'
            }
        })

        const priorityClass = computed(() => {
            switch (props.task.priority) {
                case 'LOW':
                    return 'text-blue-500'
                case 'MEDIUM':
                    return 'text-yellow-500'
                case 'HIGH':
                    return 'text-red-500'
                default:
                    return ''
            }
        })

        const borderClass = computed(() => {
            switch (props.task.status) {
                case 'TODO':
                    return 'border-l-4 border-yellow-400'
                case 'IN_PROGRESS':
                    return 'border-l-4 border-blue-400'
                case 'COMPLETED':
                    return 'border-l-4 border-green-400'
                default:
                    return 'border-l-4 border-gray-400'
            }
        })

        const badgeClass = computed(() => {
            switch (props.task.status) {
                case 'TODO':
                    return 'badge-warning'
                case 'IN_PROGRESS':
                    return 'badge-info'
                case 'COMPLETED':
                    return 'badge-success'
                default:
                    return 'badge-ghost'
            }
        })

        return {
            timeRemaining,
            timeRemainingClass,
            statusLabel,
            priorityLabel,
            priorityClass,
            borderClass,
            badgeClass,
            route
        }
    }
}
</script>
