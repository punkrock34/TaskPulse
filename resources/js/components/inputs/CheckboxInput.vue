<template>
    <div class="relative mb-6">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input
                    :id="id"
                    :value="modelValue"
                    type="checkbox"
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                    @input="$emit('update:modelValue', $event.target.checked)"
                />
            </div>
            <label :for="id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                {{ label }}
            </label>
        </div>
        <SpanError :has-error="hasError" :error="error" />
    </div>
</template>

<script>
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'CheckboxInput',
    components: {
        SpanError
    },
    props: {
        id: { type: String, required: true },
        modelValue: { type: Boolean, required: true },
        label: { type: String, required: true },
        hasError: { type: Boolean, default: false },
        error: { type: String, default: '' }
    },
    emits: ['update:modelValue']
}
</script>
