<!doctype html>
<html lang="en">
<head>
    <title>sample!</title>
</head>
<body>
    <h1>service worker sample</h1>
    <p>
        please allow the browser permission for notifications, then use <code>./artisan push:notif</code> to test push
        notifications!
    </p>

    <script>
        // The URL of the service worker script file. Can control tabs within the subdirectory it's located in or lower,
        // so put it in the root of the site area it serves.
        const SERVICE_WORKER_URL = '/service_worker.js';

        (function() {
            if (!'serviceWorker' in navigator) {
                console.error('Service workers are not supported');
                return;
            }

            navigator.serviceWorker.register(SERVICE_WORKER_URL);
        })();
    </script>
</body>
</html>
