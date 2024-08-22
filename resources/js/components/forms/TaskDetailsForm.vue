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
            v-model="form.deadline"
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
                :loading="form.processing"
                :disabled="form.processing"
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
import { useForm } from '@inertiajs/vue3'
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import { route } from 'ziggy-js'
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
    emits: ['submit', 'update-border-color'],
    setup(props, { emit }) {
        const form = useForm({
            id: props.task.id,
            title: props.task.title,
            description: props.task.description || '',
            status: props.task.status,
            priority: props.task.priority,
            deadline: props.task.deadline
                ? new Date(props.task.deadline).toISOString().split('T')[0]
                : '',
            notes: props.task.notes || '',
            attachments: props.task.attachments || []
        })

        const showModal = ref(false)
        const minDate = ref(getMinDate())

        const formattedCreatedAt = computed(() => formatCreatedAt(props.task.created_at))
        const timeRemaining = ref(calculateTimeRemaining(form.deadline))
        const timeRemainingClass = computed(() => getTimeRemainingClass(form.deadline))

        watch(
            () => form.deadline,
            (newDeadline) => {
                timeRemaining.value = calculateTimeRemaining(newDeadline)
            }
        )

        watch(
            () => form.status,
            (newStatus) => {
                emit('update-border-color', getBorderColorClass(newStatus))
            }
        )

        watch(
            () => props.task,
            (newTask) => {
                Object.keys(form).forEach((key) => {
                    if (key in newTask) {
                        form[key] = newTask[key]
                    }
                })
                if (newTask.deadline) {
                    form.deadline = new Date(newTask.deadline).toISOString().split('T')[0]
                }
            },
            { deep: true }
        )

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
            form.put(route('task.update', form.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    const updatedTask = page.props.task
                    Object.keys(form).forEach((key) => {
                        if (key in updatedTask) {
                            form[key] = updatedTask[key]
                        }
                    })
                    if (updatedTask.deadline) {
                        form.deadline = new Date(updatedTask.deadline).toISOString().split('T')[0]
                    }
                    form.success = page.props.success
                    emit('update-border-color', getBorderColorClass(form.status))
                },
                onError: (errors) => {
                    form.errors.error = errors
                }
            })
        }

        function toggleModal() {
            showModal.value = !showModal.value
        }

        function getBorderColorClass(status) {
            switch (status) {
                case TaskStatus.TODO:
                    return 'border-yellow-400'
                case TaskStatus.IN_PROGRESS:
                    return 'border-blue-400'
                case TaskStatus.COMPLETED:
                    return 'border-green-400'
                default:
                    return 'border-gray-400'
            }
        }

        return {
            form,
            minDate,
            formattedCreatedAt,
            timeRemaining,
            timeRemainingClass,
            statusOptions,
            priorityOptions,
            showModal,
            handleSubmit,
            toggleModal
        }
    }
}

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
