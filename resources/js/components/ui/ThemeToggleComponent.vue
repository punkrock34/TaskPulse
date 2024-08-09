<template>
    <button class="theme-toggle" @click="toggleTheme">
        <span v-if="isDark" class="dark-mode">
            <i class="fas fa-sun"></i>
        </span>
        <span v-else class="light-mode">
            <i class="fas fa-moon"></i>
        </span>
    </button>
</template>

<script>
export default {
    name: 'ThemeToggleComponent',
    data() {
        return {
            isDark: false
        }
    },
    mounted() {
        // Check the user's theme preference from local storage
        const storedTheme = localStorage.getItem('theme')
        if (storedTheme) {
            this.isDark = storedTheme === 'dark'
        } else {
            // Fallback to browser preference if no local storage value is found
            this.isDark =
                window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
        }
        this.applyTheme()
    },
    methods: {
        toggleTheme() {
            this.isDark = !this.isDark
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light')
            this.applyTheme()
        },
        applyTheme() {
            if (this.isDark) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        }
    }
}
</script>

<style scoped>
.theme-toggle {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
}
.dark-mode {
    color: #f39c12;
}
.light-mode {
    color: #2c3e50;
}
</style>
