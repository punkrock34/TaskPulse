<template>
    <transition name="fade-slide" @enter="enter" @leave="leave">
        <span v-show="actionLink" class="mt-1 mb-1 block">
            <p class="text-red-600 text-md">
                {{ preActionText }}
            </p>
            <a
                href="#"
                class="text-blue-700 hover:underline dark:text-blue-500"
                @click.prevent="actionLink"
            >
                {{ actionText }}
            </a>
            <p v-if="postActionText" class="text-red-600 text-md">
                {{ postActionText }}
            </p>
        </span>
    </transition>
</template>

<script>
export default {
    name: 'SpanWithActionLink',
    props: {
        preActionText: { type: String, default: 'Please verify your email address.' },
        actionText: { type: String, default: 'Resend verification email' },
        postActionText: { type: String, default: '' },
        actionLink: { type: Function, default: () => {} }
    },
    methods: {
        enter(el) {
            el.style.height = 'auto'
            const height = el.offsetHeight
            el.style.height = '0px'
            el.offsetHeight // force repaint
            el.style.transition = 'height 0.5s ease'
            el.style.height = height + 'px'
        },
        leave(el) {
            el.style.height = el.offsetHeight + 'px'
            el.offsetHeight // force repaint
            el.style.transition = 'height 0.5s ease'
            el.style.height = '0px'
        }
    }
}
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: opacity 0.5s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
}
.fade-slide-enter-to,
.fade-slide-leave-from {
    opacity: 1;
}
</style>
