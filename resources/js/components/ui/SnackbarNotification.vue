<template>
    <transition name="bounce-slide">
        <div
            v-if="visible"
            class="toast toast-end toast-top"
            @mouseenter="clearAutoHide"
            @mouseleave="autoHide"
        >
            <div class="alert bg-primary text-white shadow-lg">
                <div class="flex-1">
                    <p>{{ message }}</p>
                </div>
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
    methods: {
        show(message, duration = 5000) {
            if (this.visible) {
                this.hide()
                clearTimeout(this.timeout)
            }
            this.message = message
            this.visible = true
            this.autoHide(duration)
        },
        hide() {
            this.visible = false
        },
        autoHide(duration = 5000) {
            clearTimeout(this.timeout)
            this.timeout = setTimeout(this.hide, duration)
        },
        clearAutoHide() {
            clearTimeout(this.timeout)
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

/* Smooth bounce-in-right */
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

/* Refined bounce out */
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
