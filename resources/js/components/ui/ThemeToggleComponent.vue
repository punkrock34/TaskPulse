<template>
    <button class="btn btn-square btn-ghost text-lg" @click="toggleTheme">
        <i :class="isDark ? 'fas fa-sun' : 'fas fa-moon'"></i>
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
        const storedTheme = localStorage.getItem('theme')
        if (storedTheme) {
            this.isDark = storedTheme === 'dark'
        } else {
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
