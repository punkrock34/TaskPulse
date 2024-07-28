<template>
    <div>
        <div v-if="status" class="mb-4 text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>

        <div v-if="error" class="mb-4 text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        status: {
            type: String,
            default: null
        },
        error: {
            type: String,
            default: null
        }
    }
}
</script>
