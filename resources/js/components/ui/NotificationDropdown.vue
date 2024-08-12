<template>
    <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle" @click.stop="toggleDropdown">
            <div class="indicator">
                <i
                    :class="['fas fa-bell text-lg', { 'bell-ring': bellRinging }]"
                    @animationend="bellRinging = false"
                ></i>
                <span v-if="unreadCount > 0" class="badge badge-sm badge-primary indicator-item">
                    {{ unreadCount }}
                </span>
            </div>
        </label>
        <div
            tabindex="0"
            class="mt-3 card card-compact dropdown-content w-80 bg-white dark:bg-gray-800 shadow-lg transition ease-out duration-300 transform origin-top-right"
            :class="{ 'scale-100 opacity-100': dropdownOpen, 'scale-95 opacity-0': !dropdownOpen }"
            @click.stop
        >
            <div class="card-body text-gray-900 dark:text-white">
                <h3 class="font-bold text-lg">Notifications</h3>
                <div
                    v-if="visibleNotifications.length === 0"
                    class="text-center py-4 text-gray-500 dark:text-gray-400"
                >
                    No new notifications
                </div>
                <ul v-else class="menu bg-gray-100 dark:bg-gray-700 w-full rounded-box">
                    <li
                        v-for="notification in visibleNotifications"
                        :key="notification.id"
                        class="mb-2 transition-all ease-in-out duration-300 transform cursor-pointer"
                        :class="{
                            'opacity-100 scale-100': notification.visible,
                            'opacity-0 scale-95': !notification.visible
                        }"
                        @click="performAction(notification.action)"
                    >
                        <div class="relative bg-white dark:bg-gray-800 rounded-lg p-4">
                            <button
                                class="absolute top-1 right-1 btn btn-ghost btn-xs p-1 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                                @click.prevent.stop="dismissNotification(notification.id)"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="flex flex-col space-y-2">
                                <span class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ notification.message }}
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, watch } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'NotificationDropdown',
    setup() {
        const store = useStore()

        const dropdownOpen = ref(false)
        const bellRinging = ref(false)

        const unreadCount = computed(() => store.getters['notifications/unreadCount'] || 0)
        const visibleNotifications = computed(
            () => store.getters['notifications/visibleNotifications'] || []
        )

        const dismissNotification = (id) => {
            store.commit('notifications/dismissNotification', id)
            dropdownOpen.value = true
        }

        const performAction = (action) => {
            if (action && typeof action.handler === 'function') {
                action.handler()
            }
        }

        const toggleDropdown = () => {
            dropdownOpen.value = !dropdownOpen.value

            if (dropdownOpen.value) {
                store.commit('notifications/markAllAsRead')
            }
        }

        // Ring the bell when there are new notifications
        watch(unreadCount, (count, prevCount) => {
            if (count > prevCount) {
                bellRinging.value = true
            }
        })

        return {
            unreadCount,
            visibleNotifications,
            dismissNotification,
            performAction,
            dropdownOpen,
            toggleDropdown,
            bellRinging
        }
    }
}
</script>

<style scoped>
.dropdown-content {
    transition:
        opacity 0.3s ease,
        transform 0.3s ease;
}

.menu > li {
    transition:
        opacity 0.3s ease,
        transform 0.3s ease;
}

.menu > li.opacity-0 {
    opacity: 0;
    transform: scale(0.95);
}

.theme-transition {
    transition:
        background-color 0.3s ease,
        color 0.3s ease;
}

.bell-ring {
    animation: ring 0.5s ease-in-out;
}

@keyframes ring {
    0% {
        transform: rotate(0deg);
    }
    25% {
        transform: rotate(15deg);
    }
    50% {
        transform: rotate(-15deg);
    }
    75% {
        transform: rotate(15deg);
    }
    100% {
        transform: rotate(0deg);
    }
}
</style>
