import defaultTheme from 'tailwindcss/defaultTheme';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/filament/**/*.blade.php',
        './vendor/filament/**/*.php',
        './vendor/filament/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#fff1f3',
                    100: '#ffe3e7',
                    200: '#ffcad3',
                    300: '#ff9fb1',
                    400: '#ff6d8d',
                    500: '#f43b67',
                    600: '#d91e36',
                    700: '#b3132b',
                    800: '#911226',
                    900: '#781321',
                },
            },
        },
    },
    plugins: [typography],
};
