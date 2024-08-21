<template>
    <div
        v-if="visible"
        class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(0, 0, 0, 0.5)"
    >
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-2xl w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Manage Attachments
                </h2>
                <button
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    @click="close"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div v-if="!fileSelected">
                <ButtonWithIcon
                    icon="fas fa-plus"
                    class="mb-4"
                    label="Add Attachment"
                    @click="triggerFileInput"
                />
            </div>

            <div v-else class="mb-4">
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Selected file: <strong>{{ fileName }}</strong>
                </p>
                <!-- Optional file preview for images -->
                <div v-if="isImage(fileName)" class="mb-4">
                    <img
                        :src="filePreview"
                        alt="File Preview"
                        class="rounded-lg max-h-40 object-cover"
                    />
                </div>
                <div class="flex flex-col space-y-3">
                    <NormalButton
                        label="Upload"
                        :custom-class="'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white'"
                        @click="uploadAttachment"
                    />
                    <NormalButton
                        label="Cancel"
                        :custom-class="'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white'"
                        @click="cancelAttachment"
                    />
                </div>
            </div>

            <input id="file" type="file" class="hidden" @change="onFileChange" />

            <div class="overflow-y-auto max-h-60 mb-6">
                <ul class="list-disc pl-5 space-y-2">
                    <li
                        v-for="attachment in localAttachments"
                        :key="attachment.id"
                        class="flex justify-between items-center"
                    >
                        <a
                            :href="attachment.path"
                            target="_blank"
                            class="text-blue-500 hover:underline dark:text-blue-400"
                        >
                            {{ attachment.name }}
                        </a>
                        <button
                            class="text-red-500 hover:text-red-700 ml-4 dark:text-red-400 dark:hover:text-red-600"
                            @click="removeAttachment(attachment.id)"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="flex justify-end">
                <NormalButton
                    label="Close"
                    :custom-class="'bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'"
                    @click="close"
                />
            </div>
        </div>
    </div>
</template>

<script>
import NormalButton from '@/components/buttons/NormalButton.vue'
import ButtonWithIcon from '@/components/buttons/ButtonWithIcon.vue'
import { ref, watch } from 'vue'
import axios from 'axios'

export default {
    name: 'AttachmentModal',
    components: {
        NormalButton,
        ButtonWithIcon
    },
    props: {
        visible: { type: Boolean, required: true },
        attachments: { type: Array, required: true },
        taskId: { type: Number, required: true }
    },

    emits: ['close'],

    setup(props) {
        const file = ref(null)
        const fileName = ref('')
        const fileSelected = ref(false)
        const filePreview = ref('')

        const localAttachments = ref([...props.attachments])

        watch(
            () => props.attachments,
            (newAttachments) => {
                localAttachments.value = [...newAttachments]
            }
        )

        const triggerFileInput = () => {
            document.getElementById('file')?.click()
        }

        const onFileChange = (event) => {
            file.value = event.target.files[0]
            if (file.value) {
                fileName.value = file.value.name
                fileSelected.value = true

                // Create a preview for image files
                if (file.value.type.startsWith('image/')) {
                    filePreview.value = URL.createObjectURL(file.value)
                } else {
                    filePreview.value = ''
                }
            }
        }

        const cancelAttachment = () => {
            fileSelected.value = false
            fileName.value = ''
            file.value = null
            filePreview.value = ''

            // Reset the file input to allow re-selecting the same file
            const fileInput = document.getElementById('file')
            if (fileInput) {
                fileInput.value = null
            }
        }

        const uploadAttachment = async () => {
            if (!file.value) return

            const formData = new FormData()
            formData.append('attachment', file.value)
            formData.append('task_id', props.taskId)

            try {
                const response = await axios.post('/attachments', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })

                // Add new attachment to localAttachments without mutating
                localAttachments.value = [...localAttachments.value, response.data.attachment]

                // After successful upload, reset the state
                cancelAttachment()
            } catch (error) {
                console.error('Error uploading attachment', error)
            }
        }

        const removeAttachment = async (attachmentId) => {
            try {
                await axios.delete(`/attachments/${attachmentId}`)

                // Remove attachment from localAttachments without mutating
                localAttachments.value = localAttachments.value.filter(
                    (att) => att.id !== attachmentId
                )
            } catch (error) {
                console.error('Error deleting attachment', error)
            }
        }

        const isImage = (fileName) => {
            return /\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(fileName)
        }

        return {
            file,
            fileName,
            fileSelected,
            filePreview,
            localAttachments,
            triggerFileInput,
            onFileChange,
            cancelAttachment,
            uploadAttachment,
            removeAttachment,
            isImage
        }
    },
    methods: {
        close() {
            this.$emit('close')
        }
    }
}
</script>
