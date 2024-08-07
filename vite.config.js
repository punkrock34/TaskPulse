import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

const port = 5173
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true
        }),
        vue()
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('resources/js', import.meta.url)),
            '@components': fileURLToPath(new URL('resources/js/components', import.meta.url)),
            '@pages': fileURLToPath(new URL('resources/js/pages', import.meta.url))
        }
    },
    server: {
        // respond to all network requests
        host: '0.0.0.0',
        port: port,
        strictPort: true,
        // Defines the origin of the generated asset URLs during development,
        // this will also be used for the public/hot file (Vite devserver URL)
        origin: origin
    }
})
