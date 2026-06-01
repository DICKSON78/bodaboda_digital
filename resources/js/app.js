/**
 * BodaBoda Digital - Main Application Entry Point
 *
 * This file is the Vite entry point (configured in vite.config.js).
 * It bootstraps the core application modules and provides shared
 * utilities used across Blade views.
 *
 * @see vite.config.js for build configuration
 */

// Import CSS (Tailwind v4 via PostCSS)
import '../css/app.css';

// Core utilities
import { showToast, formatCurrency, csrfToken } from './utils/helpers.js';

// Make helpers globally available for inline Blade scripts
window.showToast = showToast;
window.formatCurrency = formatCurrency;
window.csrfToken = csrfToken;

/**
 * Initialize application-wide features on DOMContentLoaded.
 * Runs once regardless of which page is loaded.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss flash messages after 5 seconds
    document.querySelectorAll('[data-flash-message]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 5000);
    });

    // Enable live status polling on ride show pages
    const rideTracker = document.querySelector('[data-ride-tracker]');
    if (rideTracker) {
        import('./modules/ride-tracker.js').then(mod => {
            mod.initRideTracker(rideTracker.dataset.rideId);
        });
    }

    // Enable ride request map on create page
    const rideMap = document.querySelector('[data-ride-map]');
    if (rideMap) {
        import('./modules/ride-map.js').then(mod => {
            mod.initRideMap(rideMap);
        });
    }

    console.log('BodaBoda Digital app initialized.');
});

// Export for use by other modules
export default {
    version: '1.0.0',
};
