<?php
// config/design.php
return [
    'brand' => [
        'name'      => env('VertexGrad', 'VertexGrad'),
        'tagline'   => 'Where Innovation Meets Opportunity',
        'logo'      => '/assets/images/logo.png',
    ],

    // --- COLOR HEX VALUES (CRITICAL for SVG and Inline Styles) ---
    'colors' => [
        'primary'       => '#00E0FF', // Neon cyan (Main accent)
        'secondary'     => '#00B0FF', // Slightly darker cyan (Used in gradients/shadows)
        'accent'        => '#19f2ff', // Lighter neon highlight (Used in gradients)
        
        // SYNCHRONIZED: Deepest background color
        'dark'          => '#0F172A', 
        
        // NEW: A slightly darker shade for contrast elements (e.g., lines, deep dividers)
        'darker'        => '#0D1322', 
        
        'light'         => '#E5E7EB', // Soft light text
        'cardLight'     => '#1F2937', // Standard card background
        
        // SYNCHRONIZED: cardDark is the same as 'dark' for consistency
        'cardDark'      => '#0F172A', 
    ],

    // --- Reusable Tailwind Class Strings ---
    'classes' => [
        // Layout
        'container'       => 'max-w-6xl mx-auto px-4 sm:px-6 lg:px-8',
        'section_y'       => 'py-20 lg:py-28',
        
        // NEW: Reusable transition utility
        'transition_base' => 'transition duration-300 ease-in-out', 
        
        // Cards & Visuals
        // Added transition_base for consistency
        'card'            => 'bg-cardLight rounded-xl shadow-xl transition duration-300 ease-in-out hover:shadow-neon_md', 
        'card_dark'       => 'bg-cardDark rounded-xl shadow-lg transition duration-300 ease-in-out hover:shadow-neon',
        
        // Heading (Used in x-section-title)
        'heading_primary' => 'text-light font-extrabold text-4xl lg:text-6xl tracking-tight',
        'text_accent'     => 'text-primary font-semibold',
        
        // NEW: Text gradient class for premium headers/titles
        'text_gradient'   => 'bg-clip-text text-transparent bg-gradient-to-r from-secondary to-accent font-extrabold',

        // Buttons
        // Used transition_base for base button consistency
        'btn_base'        => 'inline-flex items-center justify-center font-semibold rounded-lg text-lg px-6 py-3 transition duration-300 ease-in-out whitespace-nowrap focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-dark',
        
        // Primary CTA (High-contrast Neon)
        'btn_primary'     => 'bg-primary text-dark hover:bg-secondary shadow-neon hover:shadow-neon_md',
        
        // Secondary CTA (Outline/Ghost style)
        'btn_secondary'   => 'bg-transparent border-2 border-primary text-primary hover:bg-primary/10',
    ],
];