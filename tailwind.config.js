const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        'text-2xl',
        'text-3xl',
        {
            pattern: /bg-(red|green|blue|yellow)-.+/,
            variants: ['lg', 'hover', 'focus', 'lg:hover'],
        },
        {
            pattern: /text-(red|green|blue|yellow)-.+/,
        },
    ],

    plugins: [require('@tailwindcss/forms')],
};
