console.log('service worker activate! *sparkle*');

self.addEventListener('push', function(event) {
    let data = event.data.json();

    let title = data.title;
    let options = data;

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(event) {
    event.waitUntil(clients.openWindow('http://example.com'));
});
