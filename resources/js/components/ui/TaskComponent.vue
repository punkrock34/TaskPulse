<template>
    <div :class="['card w-full shadow-md mb-4 theme-transition', borderColorClass]">
        <div class="card-body p-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="card-title text-lg font-semibold text-gray-900 dark:text-white">
                    {{ task.title }}
                </h2>
                <StatusBadge :status="task.status" />
            </div>
            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ task.description }}</p>

            <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span :class="timeRemainingClass">{{ timeRemaining }}</span>
                </div>
                <div class="flex items-center justify-end">
                    <i class="fas fa-flag mr-2"></i>
                    <PriorityBadge :priority="task.priority" />
                </div>
            </div>

            <div class="card-actions justify-end mt-4">
                <LinkButton
                    :href="route('task.index', { id: task.id })"
                    label="View Details"
                    type="button"
                    class="btn btn-primary btn-sm"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { route } from 'ziggy-js'
import LinkButton from '@/components/buttons/LinkButton.vue'
import StatusBadge from '@/components/common/StatusBadge.vue'
import PriorityBadge from '@/components/common/PriorityBadge.vue'
import { TaskStatus } from '@/enums/taskStatus'
import { TaskPriority } from '@/enums/taskPriority'

export default {
    name: 'TaskComponent',
    components: {
        LinkButton,
        StatusBadge,
        PriorityBadge
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
            if (diff < 0) return 'Overdue'
            const days = Math.floor(diff / (1000 * 60 * 60 * 24))
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
            return `${days}d ${hours}h`
        })

        const timeRemainingClass = computed(() => {
            if (!props.task.deadline) return 'text-gray-500'
            const diff = new Date(props.task.deadline) - new Date()
            if (diff < 0) return 'text-error'
            if (diff < 1000 * 60 * 60 * 24 * 2) return 'text-warning'
            return 'text-success'
        })

        const borderColorClass = computed(() => {
            switch (props.task.status) {
                case TaskStatus.TODO:
                    return 'border-l-4 border-warning'
                case TaskStatus.IN_PROGRESS:
                    return 'border-l-4 border-info'
                case TaskStatus.COMPLETED:
                    return 'border-l-4 border-success'
                default:
                    return 'border-l-4 border-base-300'
            }
        })

        return {
            timeRemaining,
            timeRemainingClass,
            borderColorClass,
            route,
            TaskStatus,
            TaskPriority
        }
    }
}
</script>
