<template>
    <AuthenticatedLayout>
        <div class="p-6 sm:p-8 rounded-lg shadow-md bg-white dark:bg-gray-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create New Task</h1>
            <CreateTaskForm />
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'
import CreateTaskForm from '@/components/forms/CreateTaskForm.vue'

export default {
    name: 'CreateTask',
    components: {
        AuthenticatedLayout,
        CreateTaskForm
    }
}
</script>
