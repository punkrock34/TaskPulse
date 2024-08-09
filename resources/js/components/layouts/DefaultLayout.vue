<template>
    <div
        class="flex flex-col min-h-screen theme-transition bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    >
        <HeaderComponent />
        <div class="container h-full w-full flex-grow mx-auto px-4 py-6 sm:py-8">
            <slot />
        </div>
        <FooterComponent />
    </div>
</template>

<script>
import HeaderComponent from '@/components/ui/HeaderComponent.vue'
import FooterComponent from '@/components/ui/FooterComponent.vue'

export default {
    name: 'DefaultLayout',
    components: {
        HeaderComponent,
        FooterComponent
    }
}
</script>
