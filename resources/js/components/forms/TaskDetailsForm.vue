<template>
    <form class="space-y-6" @submit.prevent="handleSubmit">
        <!-- Task Metadata -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Created At: {{ formattedCreatedAt }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-right">
                Time Remaining: <span :class="timeRemainingClass">{{ timeRemaining }}</span>
            </p>
        </div>

        <!-- Deadline Field -->
        <DateInput
            id="deadline"
            v-model="deadline"
            label="Deadline"
            :min-date="minDate"
            :error="form.errors.deadline"
        />

        <!-- Task Title -->
        <TextInput
            id="title"
            v-model="form.title"
            label="Title"
            placeholder="Task Title"
            :error="form.errors.title"
            required
        />

        <!-- Task Description -->
        <TextArea
            id="description"
            v-model="form.description"
            label="Description"
            placeholder="Task Description"
            :error="form.errors.description"
        />

        <!-- Task Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <SelectInput
                id="status"
                v-model="form.status"
                label="Status"
                :options="statusOptions"
                :error="form.errors.status"
            />

            <SelectInput
                id="priority"
                v-model="form.priority"
                label="Priority"
                :options="priorityOptions"
                :error="form.errors.priority"
            />
        </div>

        <!-- Editable Notes -->
        <TextArea
            id="notes"
            v-model="form.notes"
            label="Notes"
            placeholder="Enter any additional notes"
            rows="4"
            :error="form.errors.notes"
        />

        <!-- Attachments Section -->
        <div class="mt-6">
            <NormalButton label="Manage Attachments" @click="toggleModal" />
        </div>

        <!-- Task Actions -->
        <div class="card-actions justify-end mt-6">
            <NormalButton
                type="submit"
                label="Save Changes"
                :loading="loading"
                :custom-class="'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white'"
            />
        </div>

        <!-- Success/Error Messages -->
        <SpanSuccess :success="form.success" />
        <SpanError :error="form.errors.error" />

        <!-- Attachment Modal -->
        <AttachmentModal
            :visible="showModal"
            :attachments="form.attachments"
            :task-id="form.id"
            @close="toggleModal"
        />
    </form>
</template>

<script>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/inputs/TextInput.vue'
import TextArea from '@/components/inputs/TextArea.vue'
import SelectInput from '@/components/inputs/SelectInput.vue'
import DateInput from '@/components/inputs/DateInput.vue'
import NormalButton from '@/components/buttons/NormalButton.vue'
import SpanError from '@/components/common/SpanError.vue'
import SpanSuccess from '@/components/common/SpanSuccess.vue'
import AttachmentModal from '@/components/ui/AttachmentModal.vue'
import { TaskStatus } from '../../enums/taskStatus'
import { TaskPriority } from '../../enums/taskPriority'

export default {
    name: 'TaskDetailsForm',
    components: {
        TextInput,
        TextArea,
        SelectInput,
        DateInput,
        NormalButton,
        SpanError,
        SpanSuccess,
        AttachmentModal
    },
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    emits: ['submit'],
    setup(props, { emit }) {
        const loading = ref(false)
        const showModal = ref(false)

        // Initialize form with useForm and bind the task data
        const form = useForm({
            ...props.task,
            notes: props.task.notes || '',
            deadline: props.task.deadline || ''
        })

        const minDate = ref(getMinDate())

        const formattedCreatedAt = computed(() => formatCreatedAt(form.created_at))

        const timeRemaining = ref(calculateTimeRemaining(form.deadline))

        const timeRemainingClass = computed(() => getTimeRemainingClass(form.deadline))

        const deadline = form.deadline ? new Date(form.deadline).toISOString().split('T')[0] : ''

        onMounted(() => {
            const interval = setInterval(() => {
                timeRemaining.value = calculateTimeRemaining(form.deadline)
            }, 1000)

            onBeforeUnmount(() => {
                clearInterval(interval)
            })
        })

        const statusOptions = Object.values(TaskStatus).map((status) => ({
            value: status,
            label: formatStatusLabel(status)
        }))

        const priorityOptions = Object.values(TaskPriority).map((priority) => ({
            value: priority,
            label: formatPriorityLabel(priority)
        }))

        function handleSubmit() {
            loading.value = true
            form.put(`/tasks/${form.id}`, {
                onSuccess: () => (form.success = 'Task updated successfully!'),
                onError: (errors) => (form.errors.error = errors.error),
                onFinish: () => {
                    loading.value = false
                    emit('submit')
                }
            })
        }

        function toggleModal() {
            showModal.value = !showModal.value
        }

        return {
            form,
            minDate,
            formattedCreatedAt,
            timeRemaining,
            timeRemainingClass,
            statusOptions,
            priorityOptions,
            loading,
            showModal,
            handleSubmit,
            toggleModal,
            deadline
        }
    }
}

// Helper functions
function getMinDate() {
    return new Date(Date.now() + 86400000).toISOString().split('T')[0]
}

function formatCreatedAt(createdAt) {
    return new Date(createdAt).toLocaleDateString()
}

function calculateTimeRemaining(deadline) {
    if (!deadline) return 'No Deadline'
    const deadlineDate = new Date(deadline)
    const now = new Date()
    const diff = deadlineDate - now
    return diff < 0 ? formatOverdueTime(diff) : formatRemainingTime(diff)
}

function formatOverdueTime(diff) {
    const days = Math.abs(Math.floor(diff / (1000 * 60 * 60 * 24)))
    const hours = Math.abs(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
    const minutes = Math.abs(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)))
    const seconds = Math.abs(Math.floor((diff % (1000 * 60)) / 1000))
    return `-${days}d ${hours}h ${minutes}m ${seconds}s`
}

function formatRemainingTime(diff) {
    const days = Math.floor(diff / (1000 * 60 * 60 * 24))
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
    const seconds = Math.floor((diff % (1000 * 60)) / 1000)
    return `${days}d ${hours}h ${minutes}m ${seconds}s`
}

function getTimeRemainingClass(deadline) {
    const diff = new Date(deadline) - new Date()
    if (diff < 0) return 'text-red-500'
    if (diff < 172800000) return 'text-yellow-500'
    return 'text-green-500'
}

function formatStatusLabel(status) {
    const labels = {
        [TaskStatus.TODO]: 'To Do',
        [TaskStatus.IN_PROGRESS]: 'In Progress',
        [TaskStatus.COMPLETED]: 'Completed'
    }
    return labels[status] || status
}

function formatPriorityLabel(priority) {
    const labels = {
        [TaskPriority.LOW]: 'Low',
        [TaskPriority.MEDIUM]: 'Medium',
        [TaskPriority.HIGH]: 'High'
    }
    return labels[priority] || priority
}
</script>
