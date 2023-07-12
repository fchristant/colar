import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    server: {
        open: '/index.html',
    },
    build: {
        outDir: 'docs',
    },
    base: '/colar/',
})
