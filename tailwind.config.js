module.exports = {
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.js',
            './resources/**/*.vue',
        ],
        options: {
            safelist: [
                /^bg-lang-/,
            ],
        },
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                brand: {
                    '50': '#fdfcfb',
                    '100': '#fcefef',
                    '200': '#f9c8e0',
                    '300': '#f19ac1',
                    '400': '#f16a9f',
                    '500': '#ff4297',
                    '600': '#d62e62',
                    '700': '#b22347',
                    '800': '#86192e',
                    '900': '#551018',
                },
            },
            fontFamily: {
                logo: [
                    'Raleway',
                    'ui-sans-serif',
                    'system-ui',
                    'sans-serif',
                ],
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('tailwind-programming-language-colors'),
    ],
};
