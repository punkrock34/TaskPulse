<template>
    <div class="card w-full bg-white dark:bg-gray-800 shadow-xl mb-4">
        <div class="card-body">
            <h2 class="card-title text-gray-900 dark:text-white">{{ task.title }}</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ task.description }}</p>
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                <span>Deadline: {{ deadlineFormatted }}</span>
            </div>
            <div class="card-actions justify-end mt-4">
                <a
                    :href="route('task.index', { id: task.id })"
                    class="btn btn-sm btn-outline dark:btn-outline dark:btn-primary text-gray-900 dark:text-white"
                >
                    View Details
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { route } from 'ziggy-js'

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

        return {
            deadlineFormatted,
            route
        }
    }
}
</script>
