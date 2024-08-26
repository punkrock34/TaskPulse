<template>
    <header class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-white theme-transition">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">TaskPulse</a>
            <div class="flex items-center space-x-4">
                <ThemeToggle />
                <!-- Add Task Icon -->
                <a
                    class="text-xl text-gray-900 dark:text-white cursor-pointer"
                    title="Add Task"
                    @click="addTask"
                >
                    <i class="fas fa-plus"></i>
                </a>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-8 rounded-full">
                            <img :src="avatarUrl" alt="Avatar" />
                        </div>
                    </label>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu p-2 shadow bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-box w-52"
                    >
                        <li><a href="#" @click.prevent="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import { route } from 'ziggy-js'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import ThemeToggle from './ThemeToggleComponent.vue'

export default {
    name: 'AuthenticatedHeader',
    components: {
        ThemeToggle
    },
    setup() {
        const page = usePage()

        const user = computed(() => page.props.auth.user)
        const avatarUrl = computed(() => {
            return (
                user.value.avatar ||
                `https://www.gravatar.com/avatar/${user.value.email}?d=identicon`
            )
        })

        const logout = () => {
            Inertia.post(route('logout.store'))
        }

        const addTask = () => {
            Inertia.visit(route('create-task.index'))
        }

        return {
            avatarUrl,
            logout,
            addTask
        }
    }
}
</script>
