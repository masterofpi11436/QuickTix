import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
      safelist: [
        // New
        "bg-blue-200","text-blue-800","dark:bg-blue-700","dark:text-blue-100",
        // In Progress
        "bg-yellow-200","text-yellow-800","dark:bg-yellow-600","dark:text-yellow-100",
        // Completed
        "bg-green-200","text-green-800","dark:bg-green-700","dark:text-green-100",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
