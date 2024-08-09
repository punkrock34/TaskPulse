<template>
    <transition name="fade-slide" @enter="enter" @leave="leave">
        <span v-show="success" class="text-green-600 text-md mt-1 mb-1 block">{{ success }}</span>
    </transition>
</template>

<script>
export default {
    name: 'SpanSuccess',
    props: {
        success: { type: String, default: '' }
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
