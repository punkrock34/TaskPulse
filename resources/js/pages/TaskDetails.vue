<template>
    <AuthenticatedLayout>
        <div class="mb-4">
            <a
                :href="route('dashboard.index')"
                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 flex items-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    />
                </svg>
                Back to Dashboard
            </a>
        </div>
        <div
            :class="borderClass"
            class="p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
        >
            <div class="card-body">
                <TaskDetailsForm :task="localTask" @update-border-color="updateBorderColor" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed, reactive, ref } from 'vue'
import { route } from 'ziggy-js'
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'
import TaskDetailsForm from '@/components/forms/TaskDetailsForm.vue'

export default {
    name: 'TaskDetails',
    components: {
        AuthenticatedLayout,
        TaskDetailsForm
    },
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const localTask = reactive({ ...props.task })
        const borderClass = ref('')

        // Initial border class based on the task status
        const initialBorderClass = computed(() => {
            switch (localTask.status) {
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

        // Set initial border class
        borderClass.value = initialBorderClass.value

        const updateBorderColor = (newBorderColor) => {
            borderClass.value = `border-l-4 ${newBorderColor}`
        }

        return {
            localTask,
            borderClass,
            updateBorderColor,
            route // Expose route function to the template
        }
    }
}
</script>
