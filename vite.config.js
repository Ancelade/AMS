import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

import livewire from '@defstudio/vite-livewire-plugin'; // <-- import

export default defineConfig({
    server: {
        watch: {ignored: ['**/lang/*.json']},
    },
    plugins: [
        laravel({
            input: ['resources/scss/styles_dark.scss', 'resources/scss/styles_light.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
