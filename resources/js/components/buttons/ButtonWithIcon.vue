<template>
    <button
        :type="type"
        :disabled="loading"
        :class="[
            'btn btn-outline w-full text-md font-medium rounded-lg flex items-center justify-center px-5 py-2.5',
            loading ? 'btn-disabled' : 'shadow-md hover:shadow-lg',
            'transition duration-150 ease-in-out',
            'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600',
            'text-gray-900 dark:text-white',
            'hover:bg-gray-100 dark:hover:bg-gray-700',
            'focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700'
        ]"
        @click="$emit('click')"
    >
        <img v-if="!loading" class="h-5 w-5 mr-2" :src="icon" :alt="alt" />
        <span v-if="loading" class="loading loading-spinner loading-md mr-2"></span>
        <span>{{ label }}</span>
    </button>
</template>

<script>
export default {
    name: 'ButtonWithIcon',
    props: {
        type: { type: String, default: 'button' },
        label: { type: String, required: true },
        alt: { type: String, required: true },
        icon: { type: String, required: true },
        loading: { type: Boolean, default: false }
    },
    emits: ['click']
}
</script>
