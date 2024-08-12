import { createStore } from 'vuex'

const notificationsModule = {
    namespaced: true,
    state() {
        return {
            notifications: []
        }
    },
    mutations: {
        addNotification(state, notification) {
            state.notifications.push(notification)
        },
        markAllAsRead(state) {
            state.notifications.forEach((notification) => {
                notification.read = true
            })
        },
        dismissNotification(state, id) {
            state.notifications = state.notifications.filter(
                (notification) => notification.id !== id
            )
        }
    },
    getters: {
        unreadCount(state) {
            return state.notifications.filter((n) => !n.read).length
        },
        visibleNotifications(state) {
            return state.notifications
        }
    }
}

const tasksModule = {
    namespaced: true,
    state() {
        return {
            tasks: []
        }
    },
    mutations: {
        addTask(state, task) {
            state.tasks.push(task)
        },
        removeTask(state, id) {
            state.tasks = state.tasks.filter((task) => task.id !== id)
        }
    },
    getters: {
        incompleteTasks(state) {
            return state.tasks.filter((task) => !task.completed)
        }
    }
}

export default createStore({
    modules: {
        notifications: notificationsModule,
        tasks: tasksModule
    }
})
