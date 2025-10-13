/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{js,ts,jsx,tsx,vue}',
        './public/**/*.html',
    ],
    darkMode: false,
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#0ea5e9',
                    50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc',
                    400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1',
                    800: '#075985', 900: '#0c4a6e', 950: '#082f49',
                },
            },
            boxShadow: { card: '0 4px 16px -4px rgb(0 0 0 / 0.1)' },
            borderRadius: { '2xl': '1rem' },
            animation: { 'fade-in': 'fade-in 300ms ease-out both' },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0', transform: 'translateY(4px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    safelist: [
        'shadow-card',
        { pattern: /(bg|text|border|ring)-(brand)-(50|100|200|300|400|500|600|700|800|900|950)/ },
        { pattern: /(bg|text|border|ring)-(emerald|indigo|cyan|amber|slate|sky|green|red)-(50|100|200|300|400|500|600|700|800|900)/ },
        'rounded-2xl',
        'animate-fade-in',
    ],
};
