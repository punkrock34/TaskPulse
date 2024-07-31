<template>
    <button
        type="button"
        class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
    >
        <div class="flex items-center justify-center">
            <img class="h-5 w-5 mr-2" :src="icon" :alt="alt" />
            <span>{{ label }}</span>
        </div>
    </button>
</template>

<script>
export default {
    name: 'SocialButton',
    props: {
        label: { type: String, required: true },
        icon: { type: String, required: true },
        alt: { type: String, required: true }
    }
}
</script>
