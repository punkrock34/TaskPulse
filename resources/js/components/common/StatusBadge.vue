<template>
    <span :class="['badge', badgeClass]">{{ statusLabel }}</span>
</template>

<script>
import { computed } from 'vue'
import { TaskStatus } from '@/enums/taskStatus'

export default {
    name: 'StatusBadge',
    props: {
        status: {
            type: String,
            required: true,
            validator: (value) => Object.values(TaskStatus).includes(value)
        }
    },
    setup(props) {
        const statusLabel = computed(() => {
            switch (props.status) {
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
            switch (props.status) {
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
            statusLabel,
            badgeClass
        }
    }
}
</script>
