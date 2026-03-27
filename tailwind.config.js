/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                rose:    '#e8436a',
                'rose-dark': '#c2274e',
                gold:    '#d4a853',
                surface: '#111119',
                's2':    '#181825',
                's3':    '#202030',
            },
            fontFamily: {
                cormorant: ['"Cormorant Garamond"', 'serif'],
                outfit:    ['Outfit', 'sans-serif'],
            },
        },
    },
    plugins: [],
}