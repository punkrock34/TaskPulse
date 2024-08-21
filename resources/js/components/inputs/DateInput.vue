<template>
    <div :class="{ 'border-red-500': error }" class="form-control mb-6">
        <label :for="id" class="label">
            <span class="label-text text-md font-medium text-gray-900 dark:text-gray-300">
                {{ label }}
                <span v-if="required" class="text-red-500">*</span>
            </span>
        </label>
        <input
            :id="id"
            :value="modelValue"
            type="date"
            :placeholder="placeholder"
            :min="minDate"
            :max="maxDate"
            class="input input-bordered w-full bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
            @input="handleInput"
        />
        <SpanError :error="error" class="mb-1" />
    </div>
</template>

<script>
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'DateInput',
    components: {
        SpanError
    },
    props: {
        id: { type: String, required: true },
        modelValue: { type: String, required: true },
        label: { type: String, required: true },
        placeholder: { type: String, default: '' },
        error: { type: String, default: '' },
        required: { type: Boolean, default: false },
        minDate: { type: String, default: '' },
        maxDate: { type: String, default: '' }
    },
    emits: ['update:modelValue'],

    methods: {
        currentDate() {
            return new Date().toISOString().split('T')[0]
        },
        handleInput(event) {
            const inputValue = event.target.value
            this.$emit('update:modelValue', inputValue)
        }
    }
}
</script>
