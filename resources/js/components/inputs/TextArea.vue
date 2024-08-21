<template>
    <div :class="{ 'border-red-500': error }" class="form-control mb-6">
        <label :for="id" class="label">
            <span class="label-text text-md font-medium text-gray-900 dark:text-gray-300">
                {{ label }}
                <span v-if="required" class="text-red-500">*</span>
            </span>
        </label>
        <textarea
            :id="id"
            v-model="internalValue"
            :placeholder="placeholder"
            class="textarea textarea-bordered w-full bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
            rows="4"
            @input="updateValue"
        ></textarea>
        <SpanError :error="error" class="mt-1" />
    </div>
</template>

<script>
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'TextArea',
    components: {
        SpanError
    },
    props: {
        id: { type: String, required: true },
        modelValue: { type: String, required: true },
        label: { type: String, required: true },
        placeholder: { type: String, default: '' },
        error: { type: String, default: '' },
        required: { type: Boolean, default: false }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            internalValue: this.modelValue
        }
    },
    watch: {
        modelValue(newValue) {
            this.internalValue = newValue
        }
    },
    methods: {
        updateValue() {
            this.$emit('update:modelValue', this.internalValue)
        }
    }
}
</script>
