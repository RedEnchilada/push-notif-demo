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

        // The URL to send push subscription information to.
        const SUBSCRIPTION_SEND_URL = '/push/subscribe';

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
                        updateSubscriptionOnServer(subscription);
                    }
                });
            }

            function subscribe(registration) {
                registration.pushManager.subscribe({
                    // The current webpush API standard prohibits subscriptions unless they are marked as
                    // userVisibleOnly, which will require all pushes to respond with a desktop notification.
                    userVisibleOnly: true,
                    applicationServerKey: SUBSCRIPTION_PUBLIC_KEY
                }).then(updateSubscriptionOnServer);
            }

            function updateSubscriptionOnServer(subscription) {
                // This information is necessary for the server to send a push to the browser. It can be sent to the
                // server using your favorite JS framework.
                let information = {
                    endpoint: subscription.endpoint,
                    key: btoa(String.fromCharCode.apply(null, new Uint8Array(subscription.getKey('p256dh')))),
                    secret: btoa(String.fromCharCode.apply(null, new Uint8Array(subscription.getKey('auth'))))
                };

                fetch(SUBSCRIPTION_SEND_URL, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json; charset=utf-8"
                    },
                    body: JSON.stringify(information)
                });
            }
        })();
    </script>
</body>
</html>
