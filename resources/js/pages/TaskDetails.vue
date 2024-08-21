<template>
    <AuthenticatedLayout>
        <div
            :class="borderClass"
            class="p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md theme-transition"
        >
            <div class="card-body">
                <TaskDetailsForm
                    :task="localTask"
                    @submit="submit"
                    @update-border-color="updateBorderColor"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed, reactive, ref } from 'vue'
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

        const submit = () => {
            // Submission logic handled by the TaskDetailsForm
        }

        const updateBorderColor = (newBorderColor) => {
            borderClass.value = `border-l-4 ${newBorderColor}`
        }

        return {
            localTask,
            borderClass,
            submit,
            updateBorderColor
        }
    }
}
</script>
