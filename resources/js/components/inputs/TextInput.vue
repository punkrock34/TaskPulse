<template>
    <div :class="{ 'border-red-500': error }" class="relative mb-6">
        <label :for="id" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>
        <input
            :id="id"
            :value="modelValue"
            :type="type"
            :placeholder="placeholder"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <SpanError :error="error" class="mb-1" />
    </div>
</template>

<script>
import SpanError from '@/components/common/SpanError.vue'

export default {
    name: 'TextInput',
    components: {
        SpanError
    },
    props: {
        id: { type: String, required: true },
        modelValue: { type: String, required: true },
        label: { type: String, required: true },
        type: { type: String, default: 'text' },
        placeholder: { type: String, default: '' },
        error: { type: String, default: '' }
    },
    emits: ['update:modelValue']
}
</script>
