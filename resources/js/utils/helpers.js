/**
 * BodaBoda Digital - Shared Utility Helpers
 */

/**
 * Display a toast notification.
 * @param {string} message - The message to display
 * @param {'success'|'error'|'info'} type - The toast type
 * @param {number} duration - Duration in ms before auto-dismiss
 */
export function showToast(message, type = 'info', duration = 4000) {
    const colors = {
        success: 'bg-green-600 text-white',
        error: 'bg-red-600 text-white',
        info: 'bg-primary text-white',
    };

    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-2xl shadow-2xl font-bold text-sm ${colors[type] || colors.info} transition-all duration-300`;
    toast.style.transform = 'translateX(120%)';
    toast.textContent = message;
    document.body.appendChild(toast);

    // Slide in
    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
    });

    // Auto remove
    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

/**
 * Format a number as TZS currency.
 * @param {number} amount
 * @returns {string}
 */
export function formatCurrency(amount) {
    if (amount === null || amount === undefined) return 'TZS 0';
    return 'TZS ' + Number(amount).toLocaleString('en-TZ', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
}

/**
 * Get the CSRF token from the meta tag.
 * @returns {string}
 */
export function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

/**
 * Make a fetch request with CSRF token.
 * @param {string} url - The URL to fetch
 * @param {object} options - Fetch options (method, body, etc.)
 * @returns {Promise<Response>}
 */
export async function apiFetch(url, options = {}) {
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json',
        },
    };

    const merged = {
        ...defaults,
        ...options,
        headers: {
            ...defaults.headers,
            ...options.headers,
        },
    };

    const response = await fetch(url, merged);

    if (!response.ok) {
        const error = await response.json().catch(() => ({ message: 'Request failed' }));
        throw new Error(error.message || `HTTP ${response.status}`);
    }

    return response.json();
}
