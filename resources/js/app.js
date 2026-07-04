import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;

/**
 * Track a WhatsApp button click without blocking navigation.
 * Uses sendBeacon so the request survives the page unload/redirect to wa.me.
 */
window.trackWhatsApp = function (payload) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const body = JSON.stringify({ ...payload, _token: token });
        const url = '/track/whatsapp-click';

        if (navigator.sendBeacon) {
            navigator.sendBeacon(url, new Blob([body], { type: 'application/json' }));
        } else {
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body,
                keepalive: true,
            });
        }
    } catch (e) {
        /* tracking must never break the click */
    }
};

Alpine.start();
