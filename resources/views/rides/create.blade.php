@extends('layouts.app')

@section('content')
<div id="ride-app" class="ride-app mt-9">

    <!-- LEFT SIDEBAR -->
    <aside class="ride-sidebar" id="ride-sidebar">
        <div class="sidebar-inner">

            <!-- Header -->
            <div class="sidebar-header">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>Request Ride</h1>
                    <p>Dodoma City • Premium Mobility</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('rides.store') }}" method="POST" id="ride-form">
                @csrf
                <input type="hidden" name="pickup_lat"  id="pickup_lat">
                <input type="hidden" name="pickup_lng"  id="pickup_lng">
                <input type="hidden" name="dest_lat"    id="dest_lat">
                <input type="hidden" name="dest_lng"    id="dest_lng">
                <input type="hidden" name="distance"    id="distance">

                <!-- Location Inputs -->
                <div class="location-inputs">
                    <!-- Timeline dots -->
                    <div class="timeline">
                        <div class="dot dot-green"></div>
                        <div class="timeline-line"></div>
                        <div class="dot dot-primary"></div>
                    </div>

                    <div class="input-stack">
                        <!-- Pickup -->
                        <div class="input-group" id="pickup-group">
                            <label>Pickup</label>
                            <div class="input-wrap">
                                <input type="text"
                                       id="pickup_input"
                                       placeholder="Where are you?"
                                       autocomplete="off">
                                <button type="button" class="locate-btn" onclick="locateMe()" title="Use my location">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="3"/>
                                        <path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                                    </svg>
                                </button>
                            </div>
                            <div id="pickup_suggestions" class="suggestions-dropdown"></div>
                        </div>

                        <!-- Destination -->
                        <div class="input-group" id="dest-group">
                            <label>Destination</label>
                            <div class="input-wrap">
                                <input type="text"
                                       id="dest_input"
                                       placeholder="Where to?"
                                       autocomplete="off">
                            </div>
                            <div id="dest_suggestions" class="suggestions-dropdown"></div>
                        </div>
                    </div>
                </div>

                <!-- Fare Card (hidden until route calculated) -->
                <div id="fare-container" class="fare-card hidden">
                    <div class="fare-top">
                        <div>
                            <span class="fare-label">Estimated Fare</span>
                            <div class="fare-amount" id="fare-display">TZS 0</div>
                        </div>
                        <div class="fare-badge" id="distance-display">0.0 km</div>
                    </div>
                    <div class="fare-meta">
                        <span>🕒 <span id="eta-display">~5 min</span></span>
                        <span>⚡ Boda Express</span>
                        <span>🛵 <span id="nearby-count">0</span> nearby</span>
                    </div>
                    <p class="fare-note">Final fare may vary based on traffic</p>
                </div>

                <!-- Submit -->
                <button type="submit" id="submit-btn" disabled class="submit-btn mt-4">
                    <span>Confirm Ride Request</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </form>

            <!-- Driver availability -->
            <div class="availability-bar" id="availability-bar">
                <div class="avail-dot" id="avail-dot"></div>
                <span id="avail-text">Searching for riders...</span>
            </div>

        </div>
    </aside>

    <!-- RIGHT MAP -->
    <main class="ride-map-wrap" id="ride-map-wrap">
        <div id="map"></div>

        <!-- Top right badge -->
        <div class="map-badge" id="map-badge">
            <div class="map-badge-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <div>
                <div class="map-badge-region">Dodoma Central</div>
                <div class="map-badge-sub" id="live-driver-count">Loading drivers...</div>
            </div>
        </div>

        <!-- Map controls -->
        <div class="map-controls">
            <button class="map-ctrl-btn" onclick="window.locateMe()" title="My location">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path stroke-linecap="round" d="M12 2v4M12 18v4M2 12h4M18 12h4"/>
                    <circle cx="12" cy="12" r="9" stroke-dasharray="2 4" stroke-linecap="round"/>
                </svg>
            </button>
            <button class="map-ctrl-btn" onclick="window.map && window.map.zoomIn()" title="Zoom in">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                </svg>
            </button>
            <button class="map-ctrl-btn" onclick="window.map && window.map.zoomOut()" title="Zoom out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M5 12h14"/>
                </svg>
            </button>
        </div>
    </main>

</div>

<!-- PRICE CONFIRMATION MODAL -->
<div id="price-modal" class="modal-overlay hidden">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-icon">🛵</div>
            <h3>Confirm Your Ride</h3>
            <p>Review your trip details below</p>
        </div>
        <div class="modal-body">
            <div class="modal-route">
                <div class="modal-stop">
                    <div class="stop-dot green"></div>
                    <div>
                        <div class="stop-label">Pickup</div>
                        <div class="stop-name" id="modal-pickup">—</div>
                    </div>
                </div>
                <div class="modal-stop-line"></div>
                <div class="modal-stop">
                    <div class="stop-dot primary"></div>
                    <div>
                        <div class="stop-label">Destination</div>
                        <div class="stop-name" id="modal-dest">—</div>
                    </div>
                </div>
            </div>
            <div class="modal-stats">
                <div class="modal-stat">
                    <span class="stat-label">Distance</span>
                    <span class="stat-value" id="modal-distance">—</span>
                </div>
                <div class="modal-stat highlight">
                    <span class="stat-label">Total Fare</span>
                    <span class="stat-value" id="modal-fare">—</span>
                </div>
                <div class="modal-stat">
                    <span class="stat-label">ETA</span>
                    <span class="stat-value" id="modal-eta">—</span>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="window.closePriceModal()">Cancel</button>
            <button class="btn-confirm" onclick="window.confirmRide()">Confirm Ride</button>
        </div>
    </div>
</div>

@push('scripts')
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Cluster -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"/>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<!-- Routing -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css"/>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<style>
/* ============================================================
   CSS VARIABLES — Brand Colors
   ============================================================ */
:root {
    --primary:        #2F6B3F;
    --primary-dark:   #1E4D2B;
    --primary-light:  #3E8E5A;
    --primary-faint:  rgba(47,107,63,0.08);
    --primary-glow:   rgba(47,107,63,0.25);
    --accent-green:   #22c55e;
    --surface:        #ffffff;
    --surface-2:      #F7F8F7;
    --surface-3:      #EFF1EF;
    --border:         #E4E8E4;
    --text-1:         #111C14;
    --text-2:         #4A5E4D;
    --text-3:         #8A9E8D;
    --map-bg:         #E8EDE8;
    --radius-sm:      8px;
    --radius-md:      14px;
    --radius-lg:      22px;
    --radius-xl:      30px;
    --shadow-sm:      0 2px 8px rgba(0,0,0,0.06);
    --shadow-md:      0 4px 24px rgba(0,0,0,0.10);
    --shadow-lg:      0 8px 40px rgba(0,0,0,0.14);
    --sidebar-w:      420px;
    --header-h:       72px;
    --transition:     0.2s cubic-bezier(0.4,0,0.2,1);
}

/* ============================================================
   GLOBAL RESETS FOR THIS PAGE
   ============================================================ */
footer { display: none !important; }

body {
    overflow: hidden !important;
    background: var(--map-bg) !important;
}

/* ============================================================
   MAIN LAYOUT — CSS Grid (sidebar | map)
   ============================================================ */
.ride-app {
    position: fixed !important;
    top: var(--header-h) !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    display: grid !important;
    grid-template-columns: var(--sidebar-w) 1fr !important;
    grid-template-rows: 1fr !important;
    overflow: hidden !important;
    z-index: 10 !important;
}

/* ============================================================
   SIDEBAR
   ============================================================ */
.ride-sidebar {
    grid-column: 1;
    grid-row: 1;
    background: var(--surface);
    border-right: 1px solid var(--border);
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 4px 0 32px rgba(0,0,0,0.08);
    z-index: 20;
    position: relative;
}

.sidebar-inner {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 28px 24px 32px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    scrollbar-width: thin;
    scrollbar-color: var(--primary-light) transparent;
}

.sidebar-inner::-webkit-scrollbar { width: 3px; }
.sidebar-inner::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 10px;
}

/* Brand header */
.sidebar-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.brand-icon {
    width: 48px;
    height: 48px;
    background: var(--primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 16px var(--primary-glow);
}

.brand-icon svg {
    width: 24px;
    height: 24px;
    stroke: white;
}

.brand-text h1 {
    font-size: 20px;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: -0.5px;
    line-height: 1.2;
    margin: 0;
    text-transform: uppercase;
}

.brand-text p {
    font-size: 10px;
    font-weight: 700;
    color: var(--text-3);
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin: 2px 0 0;
}

/* ============================================================
   LOCATION INPUTS
   ============================================================ */
.location-inputs {
    display: flex;
    gap: 12px;
    position: relative;
}

.timeline {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 32px;
    gap: 0;
    flex-shrink: 0;
    width: 14px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid white;
    box-shadow: 0 0 0 2px currentColor;
}

.dot-green   { color: var(--accent-green);  background: var(--accent-green); }
.dot-primary { color: var(--primary);       background: var(--primary); }

.timeline-line {
    flex: 1;
    width: 2px;
    background: repeating-linear-gradient(
        to bottom,
        var(--border) 0px,
        var(--border) 4px,
        transparent 4px,
        transparent 8px
    );
    margin: 4px 0;
    min-height: 20px;
}

.input-stack {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
}

.input-group label {
    font-size: 10px;
    font-weight: 800;
    color: var(--text-3);
    letter-spacing: 1px;
    text-transform: uppercase;
    padding-left: 2px;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrap input {
    width: 100%;
    padding: 14px 44px 14px 16px;
    background: var(--surface-2);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    color: var(--text-1);
    outline: none;
    transition: var(--transition);
    box-sizing: border-box;
}

.input-wrap input::placeholder { color: var(--text-3); font-weight: 400; }

.input-wrap input:focus {
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px var(--primary-faint);
}

.input-wrap input.filled {
    border-color: var(--primary);
    background: white;
}

.locate-btn {
    position: absolute;
    right: 10px;
    width: 28px;
    height: 28px;
    border: none;
    background: var(--primary-faint);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    transition: var(--transition);
}

.locate-btn:hover { background: var(--primary); color: white; }
.locate-btn svg   { width: 14px; height: 14px; stroke: currentColor; }

/* Suggestions dropdown */
.suggestions-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    max-height: 220px;
    overflow-y: auto;
    z-index: 9999;
    display: none;
}

.suggestions-dropdown.open { display: block; }

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    cursor: pointer;
    transition: var(--transition);
    border-bottom: 1px solid var(--border);
}

.suggestion-item:last-child { border-bottom: none; }
.suggestion-item:hover      { background: var(--primary-faint); }

.sugg-icon {
    width: 32px;
    height: 32px;
    background: var(--surface-3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--primary);
}

.sugg-icon svg { width: 14px; height: 14px; stroke: currentColor; }

.sugg-name { font-size: 13px; font-weight: 600; color: var(--text-1); }
.sugg-area { font-size: 11px; color: var(--text-3); }

/* ============================================================
   FARE CARD
   ============================================================ */
.fare-card {
    background: var(--primary);
    border-radius: var(--radius-lg);
    padding: 22px 22px 16px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--primary-glow);
    transition: opacity 0.3s, transform 0.3s;
}

.fare-card.hidden {
    display: none;
}

.fare-card::before {
    content: '';
    position: absolute;
    top: -30px;
    right: -30px;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}

.fare-card::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: -20px;
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}

.fare-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
    position: relative;
    z-index: 1;
}

.fare-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    opacity: 0.7;
    display: block;
    margin-bottom: 4px;
}

.fare-amount {
    font-size: 32px;
    font-weight: 900;
    letter-spacing: -1px;
    line-height: 1;
}

.fare-badge {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.fare-meta {
    display: flex;
    gap: 14px;
    font-size: 11px;
    font-weight: 600;
    opacity: 0.85;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
    flex-wrap: wrap;
}

.fare-note {
    font-size: 10px;
    opacity: 0.55;
    margin: 0;
    position: relative;
    z-index: 1;
    font-style: italic;
}

/* ============================================================
   SUBMIT BUTTON
   ============================================================ */
.submit-btn {
    width: 100%;
    padding: 18px 24px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: var(--transition);
    box-shadow: 0 6px 24px var(--primary-glow);
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
    opacity: 0;
    transition: var(--transition);
}

.submit-btn:hover:not(:disabled)::before { opacity: 1; }
.submit-btn:hover:not(:disabled)         { transform: translateY(-1px); box-shadow: 0 10px 32px var(--primary-glow); }
.submit-btn:active:not(:disabled)        { transform: translateY(0); }

.submit-btn:disabled {
    opacity: 0.45;
    cursor: not-allowed;
    box-shadow: none;
}

.submit-btn svg {
    width: 18px;
    height: 18px;
    stroke: white;
    transition: transform var(--transition);
}

.submit-btn:hover:not(:disabled) svg { transform: translateX(4px); }

/* ============================================================
   AVAILABILITY BAR
   ============================================================ */
.availability-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--surface-2);
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-2);
    margin-top: auto;
}

.avail-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--text-3);
    flex-shrink: 0;
    transition: background 0.5s;
}

.avail-dot.high   { background: #22c55e; animation: pulse-dot 2s infinite; }
.avail-dot.medium { background: #f59e0b; }
.avail-dot.low    { background: #ef4444; }

@keyframes pulse-dot {
    0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
    50%       { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
}

/* ============================================================
   MAP AREA
   ============================================================ */
.ride-map-wrap {
    grid-column: 2;
    grid-row: 1;
    position: relative;
    height: 100%;
    background: var(--map-bg);
    overflow: hidden;
}

#map {
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    z-index: 1 !important;
    background: var(--map-bg) !important;
}

/* Map top-right badge */
.map-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 1000;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-lg);
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--shadow-md);
}

.map-badge-icon {
    width: 36px;
    height: 36px;
    background: var(--primary-faint);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

.map-badge-icon svg { width: 18px; height: 18px; stroke: currentColor; }

.map-badge-region {
    font-size: 13px;
    font-weight: 800;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.map-badge-sub {
    font-size: 11px;
    color: var(--text-3);
    font-weight: 600;
    margin-top: 1px;
}

/* Custom map controls */
.map-controls {
    position: absolute;
    bottom: 32px;
    right: 16px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.map-ctrl-btn {
    width: 46px;
    height: 46px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.map-ctrl-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: 0 4px 16px var(--primary-glow);
    transform: scale(1.05);
}

.map-ctrl-btn svg { width: 18px; height: 18px; stroke: currentColor; }

/* ============================================================
   LEAFLET OVERRIDES
   ============================================================ */
.leaflet-container {
    background: var(--map-bg) !important;
    font-family: inherit !important;
}

.leaflet-control-zoom,
.leaflet-control-attribution { display: none !important; }

.leaflet-routing-container { display: none !important; }

.leaflet-popup-content-wrapper {
    border-radius: 16px !important;
    box-shadow: var(--shadow-lg) !important;
    border: 1px solid var(--border) !important;
    padding: 0 !important;
    overflow: hidden !important;
}

.leaflet-popup-content {
    margin: 0 !important;
    width: auto !important;
}

.leaflet-popup-tip-container { display: none !important; }

/* ============================================================
   RIDER POPUP CARD
   ============================================================ */
.rider-popup {
    width: 220px;
    padding: 14px;
    font-family: inherit;
}

.rider-popup-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.rider-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    border: 2px solid var(--primary-light);
    flex-shrink: 0;
    overflow: hidden;
}

.rider-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rider-name {
    font-size: 13px;
    font-weight: 800;
    color: var(--text-1);
    line-height: 1.2;
}

.rider-plate {
    font-size: 11px;
    font-weight: 700;
    color: var(--primary);
    margin-top: 1px;
}

.rider-eta {
    font-size: 10px;
    color: var(--text-3);
    margin-top: 1px;
}

.rider-popup-actions {
    display: flex;
    gap: 6px;
}

.popup-btn {
    flex: 1;
    padding: 8px;
    border-radius: 8px;
    border: none;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
}

.popup-btn.call {
    background: var(--surface-3);
    color: var(--primary);
}

.popup-btn.call:hover { background: var(--border); }

.popup-btn.book {
    background: var(--primary);
    color: white;
}

.popup-btn.book:hover { background: var(--primary-dark); }

/* ============================================================
   MODAL
   ============================================================ */
.modal-overlay {
    position: fixed !important;
    inset: 0 !important;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 99999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 24px;
}

.modal-overlay.hidden { display: none !important; }

.modal-card {
    background: white;
    border-radius: var(--radius-xl);
    max-width: 420px;
    width: 100%;
    box-shadow: 0 32px 80px rgba(0,0,0,0.25);
    overflow: hidden;
    animation: modalIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
}

@keyframes modalIn {
    from { transform: scale(0.9) translateY(20px); opacity: 0; }
    to   { transform: scale(1) translateY(0);      opacity: 1; }
}

.modal-header {
    background: var(--primary);
    padding: 28px 28px 24px;
    text-align: center;
    color: white;
}

.modal-icon {
    font-size: 36px;
    margin-bottom: 8px;
    display: block;
}

.modal-header h3 {
    font-size: 22px;
    font-weight: 900;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}

.modal-header p {
    font-size: 13px;
    opacity: 0.75;
    margin: 0;
}

.modal-body { padding: 24px 28px; }

.modal-route {
    background: var(--surface-2);
    border-radius: var(--radius-md);
    padding: 16px;
    margin-bottom: 16px;
}

.modal-stop {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.stop-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 3px;
    border: 2px solid white;
}

.stop-dot.green   { background: var(--accent-green);  box-shadow: 0 0 0 2px var(--accent-green); }
.stop-dot.primary { background: var(--primary);       box-shadow: 0 0 0 2px var(--primary); }

.modal-stop-line {
    width: 2px;
    height: 20px;
    background: var(--border);
    margin-left: 5px;
    margin: 4px 0 4px 5px;
}

.stop-label { font-size: 10px; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.8px; }
.stop-name  { font-size: 13px; font-weight: 700; color: var(--text-1); margin-top: 2px; }

.modal-stats {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
}

.modal-stat {
    background: var(--surface-2);
    border-radius: var(--radius-sm);
    padding: 12px;
    text-align: center;
}

.modal-stat.highlight {
    background: var(--primary);
    color: white;
}

.stat-label { display: block; font-size: 10px; font-weight: 700; opacity: 0.65; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px; }
.stat-value { display: block; font-size: 15px; font-weight: 900; color: var(--text-1); }
.modal-stat.highlight .stat-value { color: white; }
.modal-stat.highlight .stat-label { opacity: 0.75; }

.modal-actions {
    display: flex;
    gap: 10px;
    padding: 0 28px 28px;
}

.btn-cancel, .btn-confirm {
    flex: 1;
    padding: 16px;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: var(--transition);
    text-transform: uppercase;
}

.btn-cancel  { background: var(--surface-3); color: var(--text-2); }
.btn-cancel:hover  { background: var(--border); }
.btn-confirm { background: var(--primary); color: white; box-shadow: 0 4px 16px var(--primary-glow); }
.btn-confirm:hover { background: var(--primary-dark); transform: translateY(-1px); }

/* ============================================================
   LOADING SPINNER
   ============================================================ */
.map-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 1000;
}

.loading-spinner {
    width: 36px;
    height: 36px;
    border: 3px solid rgba(47,107,63,0.15);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* ============================================================
   MOBILE
   ============================================================ */
@media (max-width: 768px) {
    .ride-app {
        grid-template-columns: 1fr !important;
        grid-template-rows: auto 1fr !important;
        top: 60px !important;
    }

    .ride-sidebar {
        grid-column: 1;
        grid-row: 1;
        max-height: 55vh;
    }

    .ride-map-wrap {
        grid-column: 1;
        grid-row: 2;
        min-height: 0;
    }
}

/* ============================================================
   CLUSTER OVERRIDES
   ============================================================ */
.leaflet-marker-icon.moto-cluster {
    background: none !important;
    border: none !important;
}

.cluster-bubble {
    width: 44px;
    height: 44px;
    background: var(--primary);
    border: 3px solid white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 13px;
    font-weight: 900;
    box-shadow: 0 4px 16px var(--primary-glow);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* --------------------------------------------------------
       BOLT-STYLE MOTORCYCLE SVG ICON
       Creates a proper motorcycle + rider SVG like Bolt app
    -------------------------------------------------------- */
    function createMotoIcon(heading = 0, isActive = false) {
        const color   = isActive ? '#22c55e' : '#2F6B3F';
        const shadow  = isActive ? 'rgba(34,197,94,0.5)' : 'rgba(47,107,63,0.4)';
        const svg = `
<svg width="52" height="52" viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <filter id="ms" x="-30%" y="-30%" width="160%" height="160%">
      <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="${shadow}" flood-opacity="0.8"/>
    </filter>
  </defs>
  <g transform="rotate(${heading}, 26, 26)" filter="url(#ms)">
    <!-- Outer circle background -->
    <circle cx="26" cy="26" r="22" fill="white" opacity="0.95"/>
    <circle cx="26" cy="26" r="22" fill="${color}" opacity="0.12"/>
    <circle cx="26" cy="26" r="21" fill="none" stroke="${color}" stroke-width="2"/>

    <!-- MOTORCYCLE BODY (top-down view, pointing up = north) -->
    <g transform="translate(26,26)">

      <!-- Rear wheel -->
      <ellipse cx="0" cy="10" rx="4.5" ry="3" fill="${color}" opacity="0.9"/>
      <ellipse cx="0" cy="10" rx="3" ry="1.8" fill="white" opacity="0.4"/>

      <!-- Front wheel -->
      <ellipse cx="0" cy="-10" rx="3.5" ry="2.5" fill="${color}" opacity="0.9"/>
      <ellipse cx="0" cy="-10" rx="2" ry="1.4" fill="white" opacity="0.4"/>

      <!-- Main body / frame -->
      <rect x="-3.5" y="-7" width="7" height="14" rx="2.5" fill="${color}"/>

      <!-- Fuel tank highlight -->
      <rect x="-2.5" y="-4" width="5" height="5" rx="1.5" fill="white" opacity="0.2"/>

      <!-- Handlebars -->
      <rect x="-7" y="-9" width="14" height="2.5" rx="1.2" fill="${color}" opacity="0.85"/>

      <!-- Rider helmet (top view circle) -->
      <circle cx="0" cy="-1.5" r="4" fill="${color}"/>
      <circle cx="0" cy="-1.5" r="2.5" fill="white" opacity="0.15"/>
      <!-- Helmet visor -->
      <ellipse cx="0" cy="-2.5" rx="2.2" ry="1.2" fill="white" opacity="0.3"/>

      <!-- Exhaust pipe -->
      <rect x="3.5" y="4" width="3" height="1.5" rx="0.7" fill="${color}" opacity="0.6"/>

      <!-- Speed direction arrow at top -->
      <polygon points="0,-14 -3,-10 3,-10" fill="${color}" opacity="0.7"/>
    </g>
  </g>
</svg>`;
        return L.divIcon({
            html: svg,
            className: '',
            iconSize:   [52, 52],
            iconAnchor: [26, 26],
            popupAnchor:[0, -26]
        });
    }

    /* Pickup pin icon */
    function createPickupIcon() {
        const svg = `
<svg width="40" height="52" viewBox="0 0 40 52" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <filter id="ps"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="rgba(34,197,94,0.5)"/></filter>
  </defs>
  <g filter="url(#ps)">
    <path d="M20 2C11.16 2 4 9.16 4 18c0 12.5 16 32 16 32s16-19.5 16-32C36 9.16 28.84 2 20 2z"
          fill="#22c55e"/>
    <circle cx="20" cy="18" r="7" fill="white" opacity="0.9"/>
    <circle cx="20" cy="18" r="4" fill="#22c55e"/>
  </g>
</svg>`;
        return L.divIcon({
            html: svg,
            className: '',
            iconSize:   [40, 52],
            iconAnchor: [20, 50],
            popupAnchor:[0, -50]
        });
    }

    /* Destination pin icon */
    function createDestIcon() {
        const svg = `
<svg width="40" height="52" viewBox="0 0 40 52" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <filter id="ds"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="rgba(47,107,63,0.5)"/></filter>
  </defs>
  <g filter="url(#ds)">
    <path d="M20 2C11.16 2 4 9.16 4 18c0 12.5 16 32 16 32s16-19.5 16-32C36 9.16 28.84 2 20 2z"
          fill="#2F6B3F"/>
    <circle cx="20" cy="18" r="7" fill="white" opacity="0.9"/>
    <circle cx="20" cy="18" r="4" fill="#2F6B3F"/>
    <rect x="18" y="10" width="4" height="10" fill="#2F6B3F" opacity="0.5" rx="1"/>
  </g>
</svg>`;
        return L.divIcon({
            html: svg,
            className: '',
            iconSize:   [40, 52],
            iconAnchor: [20, 50],
            popupAnchor:[0, -50]
        });
    }

    /* --------------------------------------------------------
       MAP INIT — Bolt-style CartoDB Voyager tiles
    -------------------------------------------------------- */
    const DODOMA_CENTER = [-6.1731, 35.7419];
    const DODOMA_BOUNDS = L.latLngBounds(
        [-6.2200, 35.6800],
        [-6.1200, 35.8000]
    );

    const map = L.map('map', {
        center:              DODOMA_CENTER,
        zoom:                14,
        zoomControl:         false,
        attributionControl:  false,
        maxBounds:           DODOMA_BOUNDS,
        maxBoundsViscosity:  0.85,
        minZoom:             12,
        maxZoom:             19
    });

    window.map = map;

    /* Bolt uses a clean, slightly warm tile style */
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    /* Invalidate size after render */
    setTimeout(() => { map.invalidateSize(); }, 100);
    setTimeout(() => { map.invalidateSize(); }, 500);

    /* --------------------------------------------------------
       STATE
    -------------------------------------------------------- */
    let pickupMarker   = null;
    let destMarker     = null;
    let routingControl = null;
    let riderMarkers   = {};
    let updateInterval = null;
    let dodomaLocations = [];
    let currentPickupName = '';
    let currentDestName   = '';

    /* --------------------------------------------------------
       CLUSTER GROUP
    -------------------------------------------------------- */
    const clusterGroup = L.markerClusterGroup({
        maxClusterRadius: 60,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        iconCreateFunction(cluster) {
            const count = cluster.getChildCount();
            return L.divIcon({
                html: `<div class="cluster-bubble">${count}</div>`,
                className: 'moto-cluster',
                iconSize: [44, 44],
                iconAnchor: [22, 22]
            });
        }
    });

    map.addLayer(clusterGroup);

    /* --------------------------------------------------------
       SMART MAP CENTERING — Bolt style
       Centers viewport on riders OR route, accounting for sidebar
    -------------------------------------------------------- */
    function smartCenter(points, options = {}) {
        if (!points || points.length === 0) {
            map.setView(DODOMA_CENTER, 14, { animate: true });
            return;
        }

        const bounds = L.latLngBounds(points);

        /* Left padding = sidebar width so markers appear in visible map area */
        const isDesktop = window.innerWidth > 768;
        const padLeft   = isDesktop ? 0 : 20;   /* sidebar is outside map on desktop */
        const padRight  = 60;
        const padTop    = 80;
        const padBot    = 80;

        try {
            map.fitBounds(bounds, {
                paddingTopLeft:     [padLeft,  padTop],
                paddingBottomRight: [padRight, padBot],
                maxZoom: options.maxZoom || 16,
                animate: true,
                duration: 0.6
            });
        } catch (e) {
            map.setView(DODOMA_CENTER, 14);
        }
    }

    /* --------------------------------------------------------
       LOAD LOCATIONS FROM DATABASE
    -------------------------------------------------------- */
    function loadLocations() {
        fetch('/api/locations')
            .then(r => r.json())
            .then(data => {
                dodomaLocations = data.map(l => ({
                    id:   l.id,
                    name: l.name,
                    lat:  parseFloat(l.latitude),
                    lng:  parseFloat(l.longitude),
                    area: l.area || ''
                }));
            })
            .catch(() => {
                dodomaLocations = [
                    { name: 'Dodoma Bus Terminal',      lat: -6.1731, lng: 35.7419, area: 'Central' },
                    { name: 'Jamhuri Stadium',           lat: -6.1658, lng: 35.7496, area: 'Central' },
                    { name: 'Dodoma University (UDOM)', lat: -6.1769, lng: 35.7369, area: 'Chamwino' },
                    { name: 'Makole Market',             lat: -6.1820, lng: 35.7300, area: 'Makole' },
                    { name: 'Dodoma Regional Hospital',  lat: -6.1700, lng: 35.7450, area: 'Central' },
                ];
            });
    }

    /* --------------------------------------------------------
       LOCATION SEARCH
    -------------------------------------------------------- */
    function setupSearch(inputId, suggestionsId, type) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(suggestionsId);

        input.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            if (q.length < 2) { dropdown.classList.remove('open'); return; }

            const filtered = dodomaLocations.filter(l =>
                l.name.toLowerCase().includes(q) || l.area.toLowerCase().includes(q)
            ).slice(0, 6);

            dropdown.innerHTML = '';

            if (filtered.length > 0) {
                filtered.forEach(loc => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.innerHTML = `
                        <div class="sugg-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="sugg-name">${loc.name}</div>
                            <div class="sugg-area">${loc.area}</div>
                        </div>`;
                    item.addEventListener('click', () => {
                        selectLocation(type, loc.lat, loc.lng, `${loc.name}${loc.area ? ', ' + loc.area : ''}`);
                        dropdown.classList.remove('open');
                    });
                    dropdown.appendChild(item);
                });
            } else if (q.length >= 3) {
                const item = document.createElement('div');
                item.className = 'suggestion-item';
                item.innerHTML = `
                    <div class="sugg-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="sugg-name">Use custom location</div>
                        <div class="sugg-area">"${this.value}"</div>
                    </div>`;
                item.addEventListener('click', () => {
                    selectLocation(type, DODOMA_CENTER[0], DODOMA_CENTER[1], this.value);
                    dropdown.classList.remove('open');
                });
                dropdown.appendChild(item);
            }

            dropdown.classList.add('open');
        });

        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    }

    /* --------------------------------------------------------
       SELECT LOCATION — places marker on map
    -------------------------------------------------------- */
    function selectLocation(type, lat, lng, name) {
        const latlng = L.latLng(lat, lng);

        if (type === 'pickup') {
            currentPickupName = name;
            document.getElementById('pickup_input').value = name;
            document.getElementById('pickup_lat').value   = lat;
            document.getElementById('pickup_lng').value   = lng;
            document.getElementById('pickup_input').classList.add('filled');

            if (pickupMarker) map.removeLayer(pickupMarker);
            pickupMarker = L.marker(latlng, {
                icon: createPickupIcon(),
                draggable: true,
                title: 'Pickup'
            }).addTo(map);

            pickupMarker.on('dragend', e => {
                const p = e.target.getLatLng();
                document.getElementById('pickup_lat').value = p.lat;
                document.getElementById('pickup_lng').value = p.lng;
                if (destMarker) calculateRoute();
            });

            map.setView(latlng, 15, { animate: true });

        } else {
            currentDestName = name;
            document.getElementById('dest_input').value = name;
            document.getElementById('dest_lat').value   = lat;
            document.getElementById('dest_lng').value   = lng;
            document.getElementById('dest_input').classList.add('filled');

            if (destMarker) map.removeLayer(destMarker);
            destMarker = L.marker(latlng, {
                icon: createDestIcon(),
                draggable: true,
                title: 'Destination'
            }).addTo(map);

            destMarker.on('dragend', e => {
                const p = e.target.getLatLng();
                document.getElementById('dest_lat').value = p.lat;
                document.getElementById('dest_lng').value = p.lng;
                if (pickupMarker) calculateRoute();
            });

            if (pickupMarker) calculateRoute();
            else map.setView(latlng, 15, { animate: true });
        }
    }

    /* --------------------------------------------------------
       ROUTE CALCULATION
    -------------------------------------------------------- */
    function calculateRoute() {
        if (!pickupMarker || !destMarker) return;

        if (routingControl) { map.removeControl(routingControl); routingControl = null; }

        /* Center map on both points while route loads */
        smartCenter([pickupMarker.getLatLng(), destMarker.getLatLng()], { maxZoom: 15 });

        routingControl = L.Routing.control({
            waypoints:       [pickupMarker.getLatLng(), destMarker.getLatLng()],
            routeWhileDragging: false,
            lineOptions: {
                styles: [
                    { color: '#2F6B3F', weight: 6, opacity: 0.9 },
                    { color: '#ffffff', weight: 2, opacity: 0.4 }
                ],
                addWaypoints: false
            },
            createMarker: () => null,
            addWaypoints:  false,
            fitSelectedRoutes: false
        }).addTo(map);

        routingControl.on('routesfound', function (e) {
            const dist = e.routes[0].summary.totalDistance / 1000;
            document.getElementById('distance').value = dist;

            fetch("{{ route('rides.calculate-fare') }}", {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ distance: dist })
            })
            .then(r => r.json())
            .then(data => {
                const nearby = Object.keys(riderMarkers).length;
                const eta    = Math.max(2, Math.floor(dist * 3) + 2);

                document.getElementById('fare-container').classList.remove('hidden');
                document.getElementById('distance-display').textContent = dist.toFixed(1) + ' km';
                document.getElementById('fare-display').textContent     = 'TZS ' + data.formatted_fare;
                document.getElementById('eta-display').textContent      = `~${eta} min`;
                document.getElementById('nearby-count').textContent     = nearby;
                document.getElementById('submit-btn').disabled          = false;

                /* Fit final route with sidebar padding */
                smartCenter(
                    [pickupMarker.getLatLng(), destMarker.getLatLng()],
                    { maxZoom: 15 }
                );
            })
            .catch(console.error);
        });
    }

    /* --------------------------------------------------------
       LIVE RIDER UPDATES — Bolt-style
    -------------------------------------------------------- */
    function updateRiders() {
        fetch("{{ route('riders.online') }}")
            .then(r => r.json())
            .then(data => {
                /* Filter to Dodoma bounds */
                const riders = data.filter(r => {
                    const lat = parseFloat(r.current_lat);
                    const lng = parseFloat(r.current_lng);
                    return lat >= -6.22 && lat <= -6.12 &&
                           lng >= 35.68 && lng <= 35.80 &&
                           !isNaN(lat) && !isNaN(lng);
                });

                clusterGroup.clearLayers();
                riderMarkers = {};

                riders.forEach(rider => {
                    const lat  = parseFloat(rider.current_lat);
                    const lng  = parseFloat(rider.current_lng);
                    const name = `${rider.first_name} ${rider.last_name || ''}`.trim();
                    const eta  = Math.floor(Math.random() * 6) + 2;

                    /* Random heading for visual variety */
                    const heading = Math.floor(Math.random() * 360);

                    const marker = L.marker([lat, lng], {
                        icon:        createMotoIcon(heading, false),
                        title:       name,
                        riseOnHover: true
                    });

                    /* Bolt-style popup */
                    const avatarHtml = rider.user?.avatar
                        ? `<img src="${rider.user.avatar}" alt="${name}">`
                        : `<span style="font-size:20px">🧑</span>`;

                    marker.bindPopup(`
                        <div class="rider-popup">
                            <div class="rider-popup-top">
                                <div class="rider-avatar">${avatarHtml}</div>
                                <div>
                                    <div class="rider-name">${name}</div>
                                    <div class="rider-plate">${rider.bike_plate || 'N/A'}</div>
                                    <div class="rider-eta">⏱ ${eta} min away</div>
                                </div>
                            </div>
                            <div class="rider-popup-actions">
                                <button class="popup-btn call"
                                        onclick="window.open('tel:${rider.phone_number || ''}','_blank')">
                                    📞 Call
                                </button>
                                <button class="popup-btn book"
                                        onclick="window.bookRider(${rider.id})">
                                    Book
                                </button>
                            </div>
                        </div>`, {
                        maxWidth: 240,
                        minWidth: 220,
                        closeButton: true
                    });

                    clusterGroup.addLayer(marker);
                    riderMarkers[rider.id] = marker;
                });

                /* Update UI counts */
                const count = riders.length;
                document.getElementById('live-driver-count').textContent =
                    count > 0 ? `${count} drivers online` : 'No drivers nearby';

                const dot  = document.getElementById('avail-dot');
                const text = document.getElementById('avail-text');

                if (count >= 5) {
                    dot.className  = 'avail-dot high';
                    text.textContent = `${count} riders available nearby`;
                } else if (count >= 2) {
                    dot.className  = 'avail-dot medium';
                    text.textContent = `${count} riders available`;
                } else if (count > 0) {
                    dot.className  = 'avail-dot low';
                    text.textContent = `${count} rider available — limited`;
                } else {
                    dot.className  = 'avail-dot';
                    text.textContent = 'No riders online right now';
                }

                /* Auto-center ONLY when no route is set */
                if (!pickupMarker && !destMarker && riders.length > 0) {
                    const pts = riders.map(r => L.latLng(
                        parseFloat(r.current_lat),
                        parseFloat(r.current_lng)
                    ));
                    smartCenter(pts, { maxZoom: 15 });
                }
            })
            .catch(console.error);
    }

    /* --------------------------------------------------------
       LOCATE ME
    -------------------------------------------------------- */
    window.locateMe = function () {
        if (!navigator.geolocation) return;
        navigator.geolocation.getCurrentPosition(pos => {
            const latlng = L.latLng(pos.coords.latitude, pos.coords.longitude);
            map.flyTo(latlng, 16, { duration: 1.5 });

            /* Auto-fill pickup */
            if (!pickupMarker) {
                selectLocation('pickup', latlng.lat, latlng.lng, 'My Location');
            }
        }, () => alert('Location access denied.'));
    };

    /* --------------------------------------------------------
       BOOK RIDER
    -------------------------------------------------------- */
    window.bookRider = function (riderId) {
        if (!pickupMarker || !destMarker) {
            alert('Please select pickup and destination first.');
            return;
        }
        window.openPriceModal();
    };

    /* --------------------------------------------------------
       MODAL
    -------------------------------------------------------- */
    window.openPriceModal = function () {
        document.getElementById('modal-pickup').textContent   = currentPickupName || document.getElementById('pickup_input').value || '—';
        document.getElementById('modal-dest').textContent     = currentDestName   || document.getElementById('dest_input').value   || '—';
        document.getElementById('modal-distance').textContent = document.getElementById('distance-display').textContent || '—';
        document.getElementById('modal-fare').textContent     = document.getElementById('fare-display').textContent     || '—';
        document.getElementById('modal-eta').textContent      = document.getElementById('eta-display').textContent      || '—';
        document.getElementById('price-modal').classList.remove('hidden');
    };

    window.closePriceModal = function () {
        document.getElementById('price-modal').classList.add('hidden');
    };

    window.confirmRide = function () {
        document.getElementById('ride-form').submit();
    };

    /* Close modal on backdrop click */
    document.getElementById('price-modal').addEventListener('click', function (e) {
        if (e.target === this) window.closePriceModal();
    });

    /* --------------------------------------------------------
       SUBMIT BUTTON → open modal
    -------------------------------------------------------- */
    document.getElementById('ride-form').addEventListener('submit', function (e) {
        e.preventDefault();
        window.openPriceModal();
    });

    /* --------------------------------------------------------
       KEYBOARD
    -------------------------------------------------------- */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') window.closePriceModal();
    });

    /* --------------------------------------------------------
       INIT
    -------------------------------------------------------- */
    loadLocations();
    setupSearch('pickup_input', 'pickup_suggestions', 'pickup');
    setupSearch('dest_input',   'dest_suggestions',   'dest');

    /* Start live updates */
    updateRiders();
    updateInterval = setInterval(updateRiders, 5000);

    window.addEventListener('beforeunload', () => clearInterval(updateInterval));

    /* Show loading shimmer on map */
    const loadingEl = document.createElement('div');
    loadingEl.className = 'map-loading';
    loadingEl.innerHTML = `
        <div class="loading-spinner"></div>
        <p style="font-size:12px;font-weight:700;color:var(--primary)">Finding riders...</p>`;
    document.getElementById('map').appendChild(loadingEl);
    setTimeout(() => loadingEl.remove(), 2500);
});
</script>
@endpush
@endsection