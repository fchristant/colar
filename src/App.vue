<template>
    <header>
        Theme:
        <Component :is="!theme ? 'span' : 'button'"
                   class="btn" :class="{'active' : !theme}"
                   :title="!theme ? null : 'Select system color scheme'"
                   @click="setTheme()"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M2.25 5.25a3 3 0 013-3h13.5a3 3 0 013 3V15a3 3 0 01-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 01-.53 1.28h-9a.75.75 0 01-.53-1.28l.621-.622a2.25 2.25 0 00.659-1.59V18h-3a3 3 0 01-3-3V5.25zm1.5 0v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5z"
                      clip-rule="evenodd"/>
            </svg>
        </Component>
        <Component :is="theme == 'dark' ? 'span' : 'button'"
                   class="btn" :class="{'active' : theme == 'dark'}"
                   :title="theme == 'dark' ? null : 'Select dark color scheme'"
                   @click="setTheme('dark')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"
                      clip-rule="evenodd"/>
            </svg>
        </Component>
        <Component :is="theme == 'light' ? 'span' : 'button'"
                   class="btn" :class="{'active' : theme == 'light'}"
                   :title="theme == 'light' ? null : 'Select dark color scheme'"
                   @click="setTheme('light')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
            </svg>
        </Component>
    </header>
    <main class="pt-6 pb-16 px-4 max-w-6xl mx-auto flex flex-col gap-y-4">
        <div v-for="(colors, name) in colar">
            <div class="flex max-lg:flex-col">
                <div class="w-16 font-semibold pr-1">{{ name }}</div>
                <div class="flex flex-wrap gap-1.5">
                    <div v-for="(color, key) in colors" class="cursor-pointer -hover:bg-gray-4 -dark:hover:bg-gray-10 rounded" @click="doCopy(color)">
                        <div class="h-10 w-16 rounded ring-1 dark:ring-inset ring-black/10 dark:ring-white/10" :style="{backgroundColor: color}"/>
                        <div class="font-medium">{{ key }}</div>
                        <div class="font-mono text-xs">{{ color }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import colar from './colar.json'
import {copyText} from 'vue3-clipboard'
import {useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";

export default {
    name: "App",
    data() {
        return {
            theme: localStorage.theme,
            colar: colar
        }
    },
    setup() {
        const toast = useToast();

        return {copyText, toast}
    },
    mounted() {
        this.applyThem()
    },
    methods: {
        doCopy(value) {
            this.copyText(value, undefined, (error, event) => {
                if (!error) {
                    this.toast.info('Copied', {
                        timeout: 1000,
                        closeOnClick: true,
                        pauseOnFocusLoss: false,
                        hideProgressBar: true,
                        pauseOnHover: false,
                        icon: false,
                    });
                }
            })
        },
        setTheme(target = null) {
            if (!target) {
                localStorage.removeItem('theme')
                this.theme = null
            } else {
                localStorage.theme = target
                this.theme = target
            }
            this.applyThem()
        },
        applyThem() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        }
    }
}
</script>
