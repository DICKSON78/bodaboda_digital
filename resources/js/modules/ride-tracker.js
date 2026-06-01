/**
 * BodaBoda Digital - Ride Tracker Module
 *
 * Handles real-time ride status updates and driver location tracking
 * on the ride show page. Uses polling as fallback when WebSocket is unavailable.
 */

import { apiFetch, showToast, formatCurrency } from '../utils/helpers.js';

let pollInterval = null;
let mapInstance = null;
let driverMarker = null;
let rideId = null;

/**
 * Initialize the ride tracker for a given ride.
 * @param {string|number} id - The ride ID
 */
export function initRideTracker(id) {
    rideId = id;
    const statusContainer = document.querySelector('[data-ride-status]');
    const driverLocation = document.querySelector('[data-driver-location]');

    if (!rideId) return;

    // Initial fetch
    fetchRideStatus();

    // Poll every 8 seconds for updates
    pollInterval = setInterval(fetchRideStatus, 8000);

    // Initialize Leaflet map if driver location element exists
    if (driverLocation && typeof L !== 'undefined') {
        initDriverMap();
    }
}

/**
 * Fetch the latest ride status from the server.
 */
async function fetchRideStatus() {
    if (!rideId) return;

    try {
        const data = await apiFetch(`/api/rides/${rideId}/status`, { method: 'GET' });

        updateStatusUI(data.ride);
        updateDriverLocationUI(data.ride);

        // If ride is completed or cancelled, stop polling
        if (data.ride.status === 'completed' || data.ride.status === 'cancelled') {
            stopPolling();
        }
    } catch (err) {
        console.warn('Ride status poll failed:', err.message);
    }
}

/**
 * Update the status badges and text.
 * @param {object} ride
 */
function updateStatusUI(ride) {
    const statusEl = document.querySelector('[data-ride-status]');
    if (!statusEl) return;

    const labels = {
        'requested': 'Looking for rider...',
        'accepted': 'Rider on the way!',
        'driver_arriving': 'Rider approaching...',
        'driver_arrived': 'Rider has arrived!',
        'ongoing': 'Trip in progress',
        'completed': 'Trip completed',
        'cancelled': 'Cancelled',
    };

    const colors = {
        'requested': 'bg-yellow-100 text-yellow-800',
        'accepted': 'bg-blue-100 text-blue-800',
        'driver_arrived': 'bg-green-100 text-green-800',
        'ongoing': 'bg-indigo-100 text-indigo-800',
        'completed': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
    };

    const status = ride.status || 'requested';
    statusEl.textContent = labels[status] || status;
    statusEl.className = `px-3 py-1 rounded-full text-xs font-bold uppercase ${colors[status] || 'bg-gray-100 text-gray-800'}`;
}

/**
 * Update the driver location display.
 * @param {object} ride
 */
function updateDriverLocationUI(ride) {
    const driverLocationEl = document.querySelector('[data-driver-location]');
    if (!driverLocationEl) return;

    if (ride.rider) {
        driverLocationEl.textContent = `Rider: ${ride.rider.name || 'Unknown'} | Plate: ${ride.rider.bike_plate || 'N/A'}`;
    }
}

/**
 * Initialize a Leaflet map showing the driver's current location.
 */
function initDriverMap() {
    const mapEl = document.getElementById('driver-map');
    if (!mapEl || typeof L === 'undefined') return;

    mapInstance = L.map('driver-map', {
        zoomControl: true,
        attributionControl: false,
    });

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        subdomains: 'abcd',
        maxZoom: 19,
    }).addTo(mapInstance);

    mapInstance.setView([-6.1731, 35.7419], 14);

    // Driver icon
    const driverIcon = L.divIcon({
        html: '<div style="width:32px;height:32px;background:#2F6B3F;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>',
        className: '',
        iconSize: [32, 32],
        iconAnchor: [16, 16],
    });

    driverMarker = L.marker([-6.1731, 35.7419], { icon: driverIcon }).addTo(mapInstance);
    driverMarker.bindPopup('Your driver');

    // Invalidate size after render
    setTimeout(() => mapInstance.invalidateSize(), 200);
}

/**
 * Stop the polling interval.
 */
export function stopPolling() {
    if (pollInterval) {
        clearInterval(pollInterval);
        pollInterval = null;
    }
}

/**
 * Clean up resources when the page unloads.
 */
export function destroy() {
    stopPolling();
    if (mapInstance) {
        mapInstance.remove();
        mapInstance = null;
    }
    driverMarker = null;
}
