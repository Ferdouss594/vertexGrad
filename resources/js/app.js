import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);

// Global access for any inline scripts in your Blade files
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// The Animation logic for your "Featured Projects"
document.addEventListener('DOMContentLoaded', () => {
    gsap.utils.toArray('.project-card').forEach((card, i) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: "top bottom-=100",
                toggleActions: "play none none reverse"
            },
            y: 50,
            opacity: 0,
            duration: 0.8,
            delay: i * 0.1, // Staggered entrance
            ease: "power2.out"
        });
    });
});