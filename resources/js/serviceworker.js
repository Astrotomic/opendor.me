import {registerRoute} from 'workbox-routing';
import {StaleWhileRevalidate} from 'workbox-strategies';
import {CacheableResponsePlugin} from 'workbox-cacheable-response';
import {CacheFirst} from 'workbox-strategies';
import {ExpirationPlugin} from 'workbox-expiration';

self.addEventListener("message", (event) => {
    if (event.data && event.data.type === "SKIP_WAITING") {
        self.skipWaiting();
    }
});

registerRoute(
    ({request}) => request.destination === 'script',
    new StaleWhileRevalidate({
        cacheName: 'scripts',
    }),
);

registerRoute(
    ({request}) => request.destination === 'style',
    new StaleWhileRevalidate({
        cacheName: 'styles',
    }),
);

registerRoute(
    ({request}) => request.destination === 'image',
    new CacheFirst({
        cacheName: 'images',
        plugins: [
            new CacheableResponsePlugin({
                statuses: [0, 200],
            }),
            new ExpirationPlugin({
                maxEntries: 100,
                maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
            }),
        ],
    }),
);

registerRoute(
    new RegExp('/*'),
    new StaleWhileRevalidate({
        cacheName: 'pwa-offline'
    })
);
