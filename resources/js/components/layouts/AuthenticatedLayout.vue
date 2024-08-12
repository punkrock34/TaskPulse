<template>
    <div
        class="flex flex-col min-h-screen theme-transition bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    >
        <AuthenticatedHeader />
        <div class="container h-full w-full flex-grow mx-auto px-4 py-6 sm:py-8">
            <slot />
        </div>
        <FooterComponent />
    </div>
</template>

<script>
import AuthenticatedHeader from '@/components/ui/AuthenticatedHeader.vue'
import FooterComponent from '@/components/ui/FooterComponent.vue'

export default {
    name: 'AuthenticatedLayout',
    components: {
        AuthenticatedHeader,
        FooterComponent
    }
}
</script>
