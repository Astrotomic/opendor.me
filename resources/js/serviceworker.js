import {registerRoute} from 'workbox-routing';
import {NetworkFirst} from 'workbox-strategies';
import {ExpirationPlugin} from 'workbox-expiration';

self.addEventListener("message", (event) => {
    if (event.data && event.data.type === "SKIP_WAITING") {
        self.skipWaiting();
    }
});

registerRoute(
    ({request}) => {
        const url = new URL(request.url);

        if (request.destination === 'image' && url.host === 'avatars.githubusercontent.com') {
            return true;
        }
        if (request.destination === 'script' && url.pathname === '/js/app.js') {
            return true;
        }
        if (request.destination === 'style' && url.pathname === '/css/app.css') {
            return true;
        }
        if (request.destination === 'font' && request.referrer.indexOf('/css/app.css') > 0) {
            return true;
        }
        if (request.destination === 'image' && url.pathname.startsWith('/images/sponsors/')) {
            return true;
        }
        if (url.pathname === '/api/user/autocomplete') {
            return true;
        }

        if (
            request.destination === 'document'
            && !url.pathname.startsWith('/app/')
            && !url.pathname.startsWith('/auth/')
            && !url.pathname.startsWith('/admin/')
            && !(url.pathname === '/' && url.hash === '#newAuth')
        ) {
            return true;
        }

        return false;
    },
    new NetworkFirst({
        cacheName: 'offline',
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 24 * 60 * 60,
            }),
        ],
    })
);
