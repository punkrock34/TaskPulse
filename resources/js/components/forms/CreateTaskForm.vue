<template>
    <form class="space-y-6" @submit.prevent="submit">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Task Title -->
            <TextInput
                id="title"
                v-model="form.title"
                label="Task Title"
                placeholder="Enter task title"
                :required="true"
                :error="form.errors.title"
            />

            <!-- Task Description -->
            <TextArea
                id="description"
                v-model="form.description"
                label="Task Description"
                placeholder="Enter task description"
                :error="form.errors.description"
                class="mt-4"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Task Deadline -->
                <DateInput
                    id="deadline"
                    v-model="form.deadline"
                    label="Deadline"
                    placeholder="Select a deadline"
                    :error="form.errors.deadline"
                    :min-date="currentDate"
                />

                <!-- Task Priority -->
                <SelectInput
                    id="priority"
                    v-model="form.priority"
                    label="Priority"
                    :options="priorityOptions"
                    :error="form.errors.priority"
                />
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex justify-end">
                <NormalButton
                    type="submit"
                    label="Create Task"
                    :loading="form.processing"
                    :disabled="form.processing"
                    class="btn btn-primary"
                />
            </div>
        </div>

        <!-- Success/Error Messages -->
        <SpanSuccess :success="form.success" />
        <SpanError :error="form.errors.error" />
    </form>
</template>

<script>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import TextInput from '@/components/inputs/TextInput.vue'
import DateInput from '@/components/inputs/DateInput.vue'
import SelectInput from '@/components/inputs/SelectInput.vue'
import TextArea from '@/components/inputs/TextArea.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import { TaskPriority } from '@/enums/taskPriority'

export default {
    name: 'CreateTaskForm',
    components: {
        TextInput,
        SelectInput,
        TextArea,
        NormalButton,
        SpanError,
        SpanSuccess,
        DateInput
    },
    setup() {
        const form = useForm({
            title: '',
            description: '',
            deadline: '',
            priority: TaskPriority.MEDIUM
        })

        const currentDate = new Date().toISOString().split('T')[0]

        const priorityOptions = computed(() =>
            Object.values(TaskPriority).map((priority) => ({
                value: priority,
                label: formatPriorityLabel(priority)
            }))
        )

        function submit() {
            form.post(route('create-task.store'), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    form.reset()
                    form.success = 'Task created successfully!'
                },
                onError: (errors) => {
                    form.errors.error = errors.error
                }
            })
        }

        function formatPriorityLabel(priority) {
            return priority.charAt(0) + priority.slice(1).toLowerCase()
        }

        return {
            form,
            submit,
            currentDate,
            priorityOptions
        }
    }
}
</script>
