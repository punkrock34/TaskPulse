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
                required
            />

            <SelectInput
                id="priority"
                v-model="form.priority"
                label="Priority"
                :options="priorityOptions"
                :error="form.errors.priority"
                required
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
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Attachments</h3>
            <ul class="list-disc pl-5 mb-4">
                <li v-for="attachment in form.attachments" :key="attachment.id">
                    <a :href="attachment.path" target="_blank">{{ attachment.name }}</a>
                    <button class="text-red-500 ml-2" @click="removeAttachment(attachment.id)">
                        Remove
                    </button>
                </li>
            </ul>
            <NormalButton label="Manage Attachments" @click="showModal = true" />
        </div>

        <!-- Task Actions -->
        <div class="card-actions justify-end mt-6">
            <NormalButton type="submit" label="Save Changes" :loading="loading" />
        </div>

        <!-- Success/Error Messages -->
        <SpanSuccess :success="form.success" />
        <SpanError :error="form.errors.error" />

        <!-- Attachment Modal -->
        <AttachmentModal
            :visible="showModal"
            :attachments="form.attachments"
            @close="showModal = false"
            @remove="removeAttachment"
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

        const minDate = ref(new Date(Date.now() + 86400000).toISOString().split('T')[0])

        const formattedCreatedAt = computed(() => new Date(form.created_at).toLocaleDateString())

        const calculateTimeRemaining = () => {
            if (!form.deadline) return 'No Deadline'

            const deadline = new Date(form.deadline)
            const now = new Date()
            const diff = deadline - now

            if (diff < 0) {
                const days = Math.abs(Math.floor(diff / (1000 * 60 * 60 * 24)))
                const hours = Math.abs(
                    Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
                )
                const minutes = Math.abs(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)))
                const seconds = Math.abs(Math.floor((diff % (1000 * 60)) / 1000))

                return `-${days}d ${hours}h ${minutes}m ${seconds}s`
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24))
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
            const seconds = Math.floor((diff % (1000 * 60)) / 1000)

            return `${days}d ${hours}h ${minutes}m ${seconds}s`
        }

        const timeRemaining = ref(calculateTimeRemaining())

        const timeRemainingClass = computed(() => {
            const diff = new Date(form.deadline) - new Date()
            return diff < 0
                ? 'text-red-500'
                : diff < 172800000
                  ? 'text-yellow-500'
                  : 'text-green-500'
        })

        onMounted(() => {
            const interval = setInterval(() => {
                timeRemaining.value = calculateTimeRemaining()
            }, 1000)

            onBeforeUnmount(() => {
                clearInterval(interval)
            })
        })

        const statusOptions = [
            { value: 'TODO', label: 'To Do' },
            { value: 'IN_PROGRESS', label: 'In Progress' },
            { value: 'COMPLETED', label: 'Completed' }
        ]

        const priorityOptions = [
            { value: 'LOW', label: 'Low' },
            { value: 'MEDIUM', label: 'Medium' },
            { value: 'HIGH', label: 'High' }
        ]

        const handleSubmit = () => {
            loading.value = true

            form.put(`/tasks/${form.id}`, {
                onSuccess: () => {
                    form.success = 'Task updated successfully!'
                },
                onError: (errors) => {
                    form.errors.error = errors.error
                },
                onFinish: () => {
                    loading.value = false
                    emit('submit')
                }
            })
        }

        const removeAttachment = (id) => {
            if (confirm('Are you sure you want to remove this attachment?')) {
                loading.value = true
                useForm().delete(`/attachments/${id}`, {
                    onSuccess: () => {
                        form.attachments = form.attachments.filter((att) => att.id !== id)
                        form.success = 'Attachment removed successfully!'
                    },
                    onError: (errors) => {
                        form.errors.error = errors.error
                    },
                    onFinish: () => {
                        loading.value = false
                    }
                })
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
            loading,
            showModal,
            handleSubmit,
            removeAttachment
        }
    }
}
</script>
