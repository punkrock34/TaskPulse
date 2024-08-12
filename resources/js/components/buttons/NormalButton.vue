<template>
    <button
        :type="type"
        :disabled="loading"
        :class="[
            'btn btn-outline w-full text-md font-medium rounded-lg flex items-center justify-center',
            loading ? 'btn-disabled' : 'shadow-md hover:shadow-lg',
            'transition duration-150 ease-in-out',
            'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600',
            'text-gray-900 dark:text-white',
            'hover:bg-gray-100 dark:hover:bg-gray-700',
            'focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700'
        ]"
        @click="$emit('click')"
    >
        <span v-if="loading" class="loading loading-spinner loading-md mr-2"></span>
        <span v-if="!loading">{{ label }}</span>
        <span v-else>Loading...</span>
    </button>
</template>

<script>
export default {
    name: 'NormalButton',
    props: {
        type: { type: String, default: 'button' },
        label: { type: String, required: true },
        loading: { type: Boolean, default: false }
    },
    emits: ['click']
}
</script>
