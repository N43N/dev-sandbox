import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/View/Resources/views/*.blade.php',
        './storage/framework/views/*.php',
        // 🔍 Deep search pathways updated here to find all your module views:
        './resources/views/**/*.blade.php',
        './resources/views/modules/**/*.blade.php',
        './resources/views/layouts/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography
    ],
};
