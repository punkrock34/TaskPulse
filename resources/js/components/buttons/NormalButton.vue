<template>
    <button
        :type="type"
        :disabled="loading"
        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center justify-center"
        @click="$emit('click')"
    >
        <span v-if="loading" class="loading loading-spinner mr-2"></span>
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
