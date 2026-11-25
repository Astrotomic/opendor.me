// Retire previously registered service workers. Remove this file after the migration.
self.addEventListener('install', (event) => {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        await self.clients.claim();
        await self.registration.unregister();
    })());
});
