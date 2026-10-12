import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const key = import.meta.env.VITE_REVERB_APP_KEY;
const wsHost = import.meta.env.VITE_REVERB_HOST;

if (key && wsHost) {
    try {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key,
            wsHost,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    } catch (error) {
        console.error('Reverb could not be initialized. Real-time updates are unavailable.', error);
    }
} else {
    console.warn('Reverb is not configured. Real-time updates are unavailable.');
}
