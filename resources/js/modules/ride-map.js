/**
 * BodaBoda Digital - Ride Request Map Module
 *
 * Provides the interactive map for the ride request/create page.
 * Handles location selection, fare calculation, and driver display.
 *
 * Note: This module complements the inline JS in rides/create.blade.php.
 * For full functionality, the inline script contains the Leaflet
 * integration that depends on CDN-loaded libraries (Leaflet, Routing, Cluster).
 */

import { apiFetch, formatCurrency, showToast } from '../utils/helpers.js';

/**
 * Initialize the ride request map.
 * @param {HTMLElement} container - The map container element
 */
export function initRideMap(container) {
    // The inline script in rides/create.blade.php handles the full map
    // initialization due to Leaflet CDN dependencies.
    // This module provides utility functions for the inline script to call.

    console.log('Ride map container ready:', container.id || 'ride-map');
}

/**
 * Calculate fare for a given distance via the server.
 * @param {number} distanceKm
 * @returns {Promise<{fare: number, formatted_fare: string}>}
 */
export async function calculateFare(distanceKm) {
    try {
        const data = await apiFetch('/rides/calculate-fare', {
            method: 'POST',
            body: JSON.stringify({ distance: distanceKm }),
        });
        return data;
    } catch (err) {
        console.error('Fare calculation failed:', err);
        return { fare: 0, formatted_fare: '0' };
    }
}

/**
 * Fetch nearby online riders.
 * @returns {Promise<Array>}
 */
export async function fetchNearbyDrivers() {
    try {
        return await apiFetch('/riders/online', { method: 'GET' });
    } catch (err) {
        console.warn('Failed to fetch nearby drivers:', err);
        return [];
    }
}

/**
 * Submit a ride request.
 * @param {object} rideData
 * @returns {Promise<object>}
 */
export async function requestRide(rideData) {
    try {
        const data = await apiFetch('/rides', {
            method: 'POST',
            body: JSON.stringify(rideData),
        });
        return data;
    } catch (err) {
        showToast(err.message, 'error');
        throw err;
    }
}
