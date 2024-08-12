import { createStore } from 'vuex'

const store = createStore({
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
})

export default store
