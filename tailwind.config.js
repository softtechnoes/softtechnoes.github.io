const plugin = require("tailwindcss/plugin");
const colors = require("tailwindcss/colors");

module.exports = {
    future: {
        purgeLayersByDefault: true,
        removeDeprecatedGapUtilities: true,
    },
    content: [
        "./index.html",
        "./src/**/*.{js,ts,jsx,tsx}"
    ],
    purge: [
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    screens: {
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
    },
    borderWidth: {
        default: '1px',
        '0': '0',
        '2': '2px',
        '4': '4px', 
    },
    theme: {
        container: {
            center: true,
        },
        fontFamily: {
            'display': ['Poppins'],
            'body': ['Poppins'],
        },
        extend: {
            colors: {
                primary: 'var(--color-primary)',
                secondary: 'var(--color-secondary)',
                tertiary: 'var(--color-tertiary)',
                background: 'var(--color-background)',
                success: 'var(--color-success)',
                warning: 'var(--color-warning)',
                danger: 'var(--color-danger)',
                info: 'var(--color-info)',
                border: 'var(--color-border)',
            },
            // Styling for print @media print { ... }
            screens: {
                'print': {'raw': 'print'},
            }
        },
        customForms: theme => ({
            default: {
                'input, textarea, select, multiselect, checkbox, radio': {
                    backgroundColor: theme('colors.tertiary'),
                    borderColor: theme('colors.secondary'),
                    borderRadius: theme('borderRadius.md'),
                    '&:focus': {
                        boxShadow: theme('boxShadow.md'),
                        borderColor: theme('colors.primary'),
                    },
                },
                'select, multiselect, checkbox, radio': {
                    iconColor: theme('colors.primary'),
                },
                'input, textarea': {
                    '&::placeholder': {
                        color: theme('colors.secondary'),
                        opacity: '1',
                    },
                    '&:focus': {
                        backgroundColor: theme('colors.tertiary'),
                    }
                },
                'checkbox, radio': {
                    '&:checked': {
                        borderColor: theme('colors.secondary'),
                        backgroundColor: theme('colors.primary'),
                    },
                },
            },
        }),
        letterSpacing: {
            tightest: '-.075em',
            tighter: '-.05em',
            tight: '-.025em',
            normal: '0',
            wide: '.01em',
            wider: '.05em',
            widest: '.25em',
           }
    },
    variants: {
        display: ['responsive', 'dropdown'],
        backgroundColor: ['hover', 'focus', 'active', 'checked'],
        margin: ['responsive'],
        padding: ['hover', 'responsive'],
        width: ['group-hover','hover','responsive'],
        opacity: ['disabled'],
    },
    plugins: [
        require('tailwindcss-dropdown'),
        require('@tailwindcss/custom-forms')
    ]
}