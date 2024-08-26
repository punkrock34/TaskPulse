<template>
    <button :type="type" :disabled="loading" :class="buttonClasses" @click="$emit('click')">
        <LoadingIndicator v-if="loading" size="md" label="Loading..." />
        <span v-else>{{ label }}</span>
    </button>
</template>

<script>
import LoadingIndicator from '@/components/common/LoadingIndicator.vue'
import { twMerge } from 'tailwind-merge'

export default {
    name: 'NormalButton',
    components: {
        LoadingIndicator
    },
    props: {
        type: { type: String, default: 'button' },
        label: { type: String, required: true },
        loading: { type: Boolean, default: false },
        customClass: { type: String, default: '' }
    },
    emits: ['click'],
    computed: {
        buttonClasses() {
            return twMerge(
                'btn btn-outline w-full text-md font-medium rounded-lg flex items-center justify-center',
                this.loading ? 'btn-disabled' : 'shadow-md hover:shadow-lg',
                'transition duration-150 ease-in-out',
                'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600',
                'text-gray-900 dark:text-white',
                'hover:bg-gray-100 dark:hover:bg-gray-700',
                'focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700',
                this.customClass
            )
        }
    }
}
</script>
