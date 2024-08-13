<template>
    <a
        :href="href"
        :class="[
            'btn btn-outline w-full text-md font-medium rounded-lg flex items-center justify-center',
            'shadow-md hover:shadow-lg',
            'transition duration-150 ease-in-out',
            'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600',
            'text-gray-900 dark:text-white',
            'hover:bg-gray-100 dark:hover:bg-gray-700',
            'focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700'
        ]"
        :target="target"
    >
        <span>{{ label }}</span>
    </a>
</template>

<script>
export default {
    name: 'LinkButton',
    props: {
        href: { type: String, required: true },
        label: { type: String, required: true },
        target: { type: String, default: '_self' } // Optionally open in a new tab with _blank
    }
}
</script>
