import {registerRoute} from 'workbox-routing';
import {NetworkFirst} from 'workbox-strategies';
import {ExpirationPlugin} from 'workbox-expiration';

self.addEventListener("message", (event) => {
    if (event.data && event.data.type === "SKIP_WAITING") {
        self.skipWaiting();
    }
});

registerRoute(
    new RegExp('/*'),
    new NetworkFirst({
        cacheName: 'pwa-offline',
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 24 * 60 * 60,
            }),
        ],
    })
);
