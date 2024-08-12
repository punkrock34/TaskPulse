<template>
    <header class="bg-white dark:bg-gray-900 p-4 text-gray-900 dark:text-white theme-transition">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">TaskPulse</a>
            <div class="flex items-center space-x-4">
                <ThemeToggle />
                <NotificationDropdown />
                <!-- Add Task Icon -->
                <i
                    class="fas fa-plus text-xl text-gray-900 dark:text-white cursor-pointer"
                    title="Add Task"
                    @click="simulateTask"
                ></i>
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
import NotificationDropdown from './NotificationDropdown.vue'
import { useStore } from 'vuex'

export default {
    name: 'AuthenticatedHeader',
    components: {
        ThemeToggle,
        NotificationDropdown
    },
    setup() {
        const page = usePage()
        const store = useStore()

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

        const addTask = (task) => {
            store.commit('tasks/addTask', task)
        }

        const simulateTask = () => {
            addTask({
                id: Date.now(),
                title: 'New task added!',
                description: 'This is a new task that was added to the list.',
                completed: false,
                created_at: new Date().toISOString(),
                deadline: new Date(Date.now() + 86400000).toISOString() // 24 hours from now
            })
        }

        return {
            avatarUrl,
            logout,
            simulateTask
        }
    }
}
</script>
