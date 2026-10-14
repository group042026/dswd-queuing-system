import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const key = import.meta.env.VITE_REVERB_APP_KEY;
const wsHost = (import.meta.env.VITE_REVERB_HOST && import.meta.env.VITE_REVERB_HOST !== 'localhost')
    ? import.meta.env.VITE_REVERB_HOST
    : (typeof window !== 'undefined' ? window.location.hostname : 'localhost');

if (key) {
    try {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key,
            wsHost,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    } catch (error) {
        console.error('Reverb could not be initialized. Real-time updates are unavailable.', error);
    }
} else {
    console.warn('Reverb is not configured. Real-time updates are unavailable.');
}

