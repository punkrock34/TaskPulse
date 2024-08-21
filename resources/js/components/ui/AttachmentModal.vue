<template>
    <div
        v-if="visible"
        class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(0, 0, 0, 0.5)"
    >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Manage Attachments
            </h2>
            <ul class="list-disc pl-5 mb-4">
                <li v-for="attachment in attachments" :key="attachment.id">
                    <a :href="attachment.path" target="_blank">{{ attachment.name }}</a>
                    <button class="text-red-500 ml-2" @click="removeAttachment(attachment.id)">
                        Remove
                    </button>
                </li>
            </ul>
            <div class="flex justify-end">
                <NormalButton label="Close" @click="close" />
            </div>
        </div>
    </div>
</template>

<script>
import NormalButton from '@/components/buttons/NormalButton.vue'

export default {
    name: 'AttachmentModal',
    components: { NormalButton },
    props: {
        visible: { type: Boolean, required: true },
        attachments: { type: Array, required: true }
    },
    emits: ['close', 'remove'],
    methods: {
        close() {
            this.$emit('close')
        },
        removeAttachment(id) {
            this.$emit('remove', id)
        }
    }
}
</script>
