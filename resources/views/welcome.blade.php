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

        // The site's VAPID public key, as a Uint8Array.
        const SUBSCRIPTION_PUBLIC_KEY = new Uint8Array({!! json_encode(
            array_map(
                function ($char) {
                    return ord($char);
                },
                str_split(base64_decode(env('VAPID_PUBLIC_KEY')))
            )
        ) !!});

        (function() {
            if (!'serviceWorker' in navigator) {
                console.error('Service workers are not supported');
                return;
            }

            if (!'PushManager' in window) {
                console.error('Push notifications are not supported');
                return;
            }

            navigator.serviceWorker.register(SERVICE_WORKER_URL).then(checkSubscriptionStatus);

            function checkSubscriptionStatus(registration) {
                registration.pushManager.getSubscription().then(function(subscription) {
                    if (subscription === null) {
                        subscribe(registration);
                    } else {
                    }
                });
            }

            function subscribe(registration) {
                registration.pushManager.subscribe({
                    // The current webpush API standard prohibits subscriptions unless they are marked as
                    // userVisibleOnly, which will require all pushes to respond with a desktop notification.
                    userVisibleOnly: true,
                    applicationServerKey: SUBSCRIPTION_PUBLIC_KEY
                });
            }
        })();
    </script>
</body>
</html>
