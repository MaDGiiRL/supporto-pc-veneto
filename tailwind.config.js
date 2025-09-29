/** @type {import('tailwindcss').Config} */
module.exports = {
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#0ea5e9',
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
            },
            boxShadow: {
                card: '0 4px 16px -4px rgb(0 0 0 / 0.1)',
            },
            borderRadius: {
                '2xl': '1rem',
            },
            animation: {
                'fade-in': 'fade-in 300ms ease-out both',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0', transform: 'translateY(4px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },
    plugins: [],
    safelist: ['shadow-card'],
};
