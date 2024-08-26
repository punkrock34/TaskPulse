<!-- src/components/ui/LoadingIndicator.vue -->
<template>
    <div class="flex items-center justify-center">
        <span v-if="showSpinner" class="loading loading-spinner" :class="spinnerSize"></span>
        <span v-if="showLabel" class="ml-2">{{ label }}</span>
    </div>
</template>

<script>
export default {
    name: 'LoadingIndicator',
    props: {
        showSpinner: { type: Boolean, default: true },
        showLabel: { type: Boolean, default: false },
        label: { type: String, default: 'Loading...' },
        size: { type: String, default: 'md' } // Options: 'sm', 'md', 'lg'
    },
    computed: {
        spinnerSize() {
            return {
                'loading-sm': this.size === 'sm',
                'loading-md': this.size === 'md',
                'loading-lg': this.size === 'lg'
            }
        }
    }
}
</script>
