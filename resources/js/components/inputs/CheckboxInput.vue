<template>
    <div class="form-control mb-6">
        <label class="cursor-pointer label">
            <input
                :id="id"
                :checked="modelValue"
                type="checkbox"
                class="checkbox checkbox-primary"
                @input="$emit('update:modelValue', $event.target.checked)"
            />
            <span class="ml-2 text-md font-medium text-gray-900 dark:text-gray-300">
                {{ label }}
            </span>
        </label>
        <SpanError :error="error" class="mb-1" />
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
        error: { type: String, default: '' }
    },
    emits: ['update:modelValue']
}
</script>
