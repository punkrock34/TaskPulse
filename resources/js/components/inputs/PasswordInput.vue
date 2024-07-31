<template>
    <div :class="{ 'has-error': hasError }" class="relative">
        <label :for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>
        <input
            :id="id"
            :value="modelValue"
            :type="visible ? 'text' : 'password'"
            :placeholder="placeholder"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <button
            type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none dark:text-gray-500 -bottom-7"
            @click="toggleVisibility"
        >
            <i :class="visible ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
        </button>
        <SpanError :has-error="hasError" :error="error" />
    </div>
</template>

<script>
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'PasswordInput',
    components: {
        SpanError
    },
    props: {
        id: { type: String, required: true },
        modelValue: { type: String, required: true },
        label: { type: String, required: true },
        placeholder: { type: String, default: '' },
        hasError: { type: Boolean, default: false },
        error: { type: String, default: '' }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            visible: false
        }
    },
    methods: {
        toggleVisibility() {
            this.visible = !this.visible
        },
        onInput(event) {
            this.$emit('update:modelValue', event.target.value)
        }
    }
}
</script>
