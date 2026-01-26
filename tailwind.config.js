/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            // Define all custom colors and use the hex values here
            colors: {
                'primary': '#00E0FF',      // Neon cyan (Main accent)
                'secondary': '#00B0FF',    // Slightly darker cyan
                'accent': '#19f2ff',       // Lighter neon highlight
                
                // SYNCHRONIZED: Deepest background color
                'dark': '#0F172A',         
                
                // NEW: Slightly darker shade for borders/dividers
                'darker': '#0D1322',      
                
                'light': '#E5E7EB',        // Soft light text
                'cardLight': '#1F2937',    // Standard card background
                'cardDark': '#0F172A',     // Same as dark
                
                // Used for background gradients
                'gradientStart': '#00E0FF',
                'gradientEnd': '#005E7A',
            },
            
            backgroundImage: ({ theme }) => ({ 
                'gradient-hero': `linear-gradient(135deg, ${theme('colors.gradientStart')}, ${theme('colors.gradientEnd')})`,
                // NOTE: The 'text_gradient' class uses this for its color flow
                'gradient-accent': `linear-gradient(90deg, ${theme('colors.secondary')}, ${theme('colors.accent')})`,
            }),
            
            boxShadow: ({ theme }) => ({ 
                neon: `0 0 16px ${theme('colors.primary')}, 0 0 32px ${theme('colors.secondary')}`,
                neon_md: `0 0 8px ${theme('colors.primary')}, 0 0 16px ${theme('colors.secondary')}`,
            }),
            
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            
            animation: {
                'fade-up': 'fade-up 1.2s ease forwards',
                'pulse-neon': 'pulse 2s infinite',
            },
            
            keyframes: {
                'fade-up': {
                    '0%': { opacity: 0, transform: 'translateY(20px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                'pulse': {
                    '0%, 100%': { opacity: 0.7, transform: 'scale(1)' },
                    '50%': { opacity: 1, transform: 'scale(1.05)' },
                },
            },
        },
    },

    // ----------------------------------------------------------------
    // PLUGIN: Required to make 'bg-clip-text' (used in text_gradient) work
    // ----------------------------------------------------------------
    plugins: [
        function ({ addUtilities }) {
            const newUtilities = {
                '.bg-clip-text': {
                    'background-clip': 'text',
                    '-webkit-background-clip': 'text',
                },
            };
            addUtilities(newUtilities, ['responsive']);
        }
    ],
};