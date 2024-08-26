<template>
    <span :class="['text-xs font-medium', priorityClass]">{{ priorityLabel }}</span>
</template>

<script>
import { computed } from 'vue'
import { TaskPriority } from '@/enums/taskPriority'

export default {
    name: 'PriorityBadge',
    props: {
        priority: {
            type: String,
            required: true,
            validator: (value) => Object.values(TaskPriority).includes(value)
        }
    },
    setup(props) {
        const priorityLabel = computed(() => {
            switch (props.priority) {
                case TaskPriority.LOW:
                    return 'Low'
                case TaskPriority.MEDIUM:
                    return 'Medium'
                case TaskPriority.HIGH:
                    return 'High'
                default:
                    return 'Unknown'
            }
        })

        const priorityClass = computed(() => {
            switch (props.priority) {
                case TaskPriority.LOW:
                    return 'text-info'
                case TaskPriority.MEDIUM:
                    return 'text-warning'
                case TaskPriority.HIGH:
                    return 'text-error'
                default:
                    return 'text-base-content'
            }
        })

        return {
            priorityLabel,
            priorityClass
        }
    }
}
</script>
