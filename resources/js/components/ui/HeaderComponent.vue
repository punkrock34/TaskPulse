<template>
    <header class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-white theme-transition">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/">
                <h2 class="text-2xl font-bold">TaskPulse</h2>
            </a>
            <ThemeToggle />
        </div>
    </header>
</template>

<script>
import ThemeToggle from './ThemeToggleComponent.vue'

export default {
    name: 'HeaderComponent',
    components: {
        ThemeToggle
    }
}
</script>
