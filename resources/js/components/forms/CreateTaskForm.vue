<template>
    <form class="space-y-4" @submit.prevent="submit">
        <!-- Success/Error Messages -->
        <SpanSuccess :success="form.success" />
        <SpanError :error="form.errors.error" />
        <!-- Task Title -->
        <TextInput
            id="title"
            v-model="form.title"
            label="Title"
            placeholder="Task Title"
            :required="true"
            :error="form.errors.title"
        />

        <!-- Task Description -->
        <TextArea
            id="description"
            v-model="form.description"
            label="Description"
            placeholder="Task Description"
            :error="form.errors.description"
        />

        <!-- Task Deadline -->
        <DateInput
            id="deadline"
            v-model="form.deadline"
            label="Deadline"
            placeholder="Select a date"
            :error="form.errors.deadline"
            :min-date="currentDate"
        />

        <!-- Task Priority -->
        <SelectInput
            id="priority"
            v-model="form.priority"
            label="Priority"
            :options="[
                { value: 'LOW', label: 'Low' },
                { value: 'MEDIUM', label: 'Medium' },
                { value: 'HIGH', label: 'High' }
            ]"
            :error="form.errors.priority"
        />

        <!-- Form Actions -->
        <NormalButton type="submit" label="Create Task" :loading="loading" />
    </form>
</template>

<script>
import { ref } from 'vue'
import { route } from 'ziggy-js'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import DateInput from '@/components/inputs/DateInput.vue'
import SelectInput from '@/components/inputs/SelectInput.vue'
import TextArea from '@/components/inputs/TextArea.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'

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
            priority: 'MEDIUM'
        })

        const loading = ref(false)

        const currentDate = new Date().toISOString().split('T')[0]

        const submit = () => {
            loading.value = true
            form.post(route('create-task.store'), {
                onSuccess: () => {
                    form.reset()
                    form.success = 'Task created successfully!'
                },
                onError: (errors) => {
                    form.errors.error = errors.error
                },
                onFinish: () => (loading.value = false)
            })
        }

        return {
            form,
            submit,
            loading,
            currentDate
        }
    }
}
</script>
