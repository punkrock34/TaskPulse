<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75 transition-opacity duration-300"
        @click="close"
    >
        <div class="relative max-w-4xl w-full h-auto max-h-[90vh] overflow-hidden" @click.stop>
            <img :src="url" :alt="alt" class="w-full h-auto object-contain rounded-lg" />
            <button
                class="absolute top-2 right-2 p-2 rounded-full bg-black bg-opacity-50 text-white hover:bg-opacity-75 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
                aria-label="Close preview"
                @click="close"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    url: {
        type: String,
        required: true
    },
    alt: {
        type: String,
        default: 'Image preview'
    }
})

const emit = defineEmits(['close'])

const close = () => {
    emit('close')
}
</script>
