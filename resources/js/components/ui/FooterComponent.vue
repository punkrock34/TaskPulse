<template>
    <footer
        class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-gray-100 shadow-lg mt-auto theme-transition"
    >
        <div class="container mx-auto text-center">
            <p class="text-sm">
                &copy; {{ new Date().getFullYear() }} TaskPulse. All rights reserved.
            </p>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'FooterComponent'
}
</script>
