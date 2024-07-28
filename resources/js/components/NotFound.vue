<template>
    <div
        class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900"
    >
        <div
            class="w-full max-w-sm p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md text-center"
        >
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-6">
                404 <span role="img" aria-label="confused face">😕</span>
            </h1>
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                Oops! You seem lost.
            </h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                We can't find the page you're looking for.
            </p>
            <router-link
                to="/"
                class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
            >
                <span role="img" aria-label="house with garden">🏡</span> Take me home
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NotFound'
}
</script>

<style scoped></style>
