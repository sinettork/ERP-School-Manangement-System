import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Siemreap for Khmer, Figtree as Latin fallback
                sans: ['Siemreap', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        // dynamic status/condition color classes used in Blade
        'bg-green-100','text-green-700','text-green-800',
        'bg-red-100','text-red-700','text-red-800',
        'bg-yellow-100','text-yellow-700','text-yellow-800',
        'bg-blue-100','text-blue-700','text-blue-800',
        'bg-purple-100','text-purple-700','text-purple-800',
        'bg-orange-100','text-orange-700',
        'bg-indigo-100','text-indigo-700',
        'bg-slate-100','text-slate-600','text-slate-700',
        'text-green-600','text-red-600',
    ],

    plugins: [forms],
};
