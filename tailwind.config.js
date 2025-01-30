/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                },
                dark: {
                    'bg-primary': '#1a1a1a',
                    'bg-secondary': '#2d2d2d',
                    'text-primary': '#ffffff',
                    'text-secondary': '#a3a3a3',
                }
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
