<template>
    <div
        id="app"
        class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    >
        <header
            class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-white theme-transition"
        >
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">TaskPulse</h1>
                <ThemeToggle />
            </div>
        </header>

        <main class="flex-grow flex">
            <router-view></router-view>
        </main>

        <footer
            class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-white mt-auto theme-transition"
        >
            <div class="container mx-auto text-center">
                <p>&copy; {{ new Date().getFullYear() }} TaskPulse. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<script>
import ThemeToggle from './components/AppThemeToggle.vue'

export default {
    name: 'App',
    components: {
        ThemeToggle
    }
}
</script>
