<template>
    <transition name="bounce-slide">
        <div
            v-if="visible"
            class="toast toast-end toast-top"
            @mouseenter="clearAutoHide"
            @mouseleave="autoHide"
        >
            <div
                class="alert shadow-lg flex items-center justify-between p-4 rounded-lg border bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600"
            >
                <div class="flex-1 text-gray-900 dark:text-white">
                    <p class="font-medium">{{ message }}</p>
                </div>
                <button
                    class="btn btn-sm btn-circle btn-ghost ml-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                    @click="hide"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'SnackbarNotification',
    data() {
        return {
            visible: false,
            message: '',
            timeout: null
        }
    },
    beforeUnmount() {
        this.clearAutoHide()
    },
    methods: {
        show(message, duration = 5000) {
            this.clearAutoHide()
            this.message = message
            this.visible = true
            this.autoHide(duration)
        },
        hide() {
            this.visible = false
        },
        autoHide(duration = 5000) {
            this.clearAutoHide()
            this.timeout = setTimeout(() => {
                this.hide()
                this.message = ''
            }, duration)
        },
        clearAutoHide() {
            if (this.timeout) {
                clearTimeout(this.timeout)
                this.timeout = null
            }
        }
    }
}
</script>

<style scoped>
.toast {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    max-width: 300px;
    z-index: 9999;
    transition:
        transform 0.6s ease-in-out,
        opacity 0.6s ease-in-out;
    max-width: 90%;
    padding: 0.75rem;
    border-radius: 0.5rem; /* Rounded corners */
}

@media (max-width: 480px) {
    .toast {
        right: 0.5rem;
        left: 0.5rem;
        bottom: 0.5rem;
        max-width: calc(100% - 1rem);
        padding: 0.5rem;
    }

    .alert {
        font-size: 0.875rem;
        word-wrap: break-word;
    }
}

.bounce-slide-enter-active {
    animation: bounce-in-right 1.6s ease forwards;
}

@keyframes bounce-in-right {
    0% {
        opacity: 0;
        transform: translateX(2000px);
    }
    60% {
        opacity: 1;
        transform: translateX(-30px);
    }
    80% {
        transform: translateX(10px);
    }
    100% {
        transform: translateX(0);
    }
}

.bounce-slide-leave-active {
    animation: bounce-slide-out 1.5s cubic-bezier(0.25, 1, 0.5, 1);
}

@keyframes bounce-slide-out {
    0% {
        transform: translateX(0);
    }
    30% {
        transform: translateX(5%);
    }
    60% {
        transform: translateX(-3%);
    }
    100% {
        transform: translateX(100%);
    }
}
</style>
