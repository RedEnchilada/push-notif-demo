# Push notification demo

This demonstrates setting up a service worker to receive push notifications from a Laravel application. Please step
through the commits individually at https://github.com/RedEnchilada/push-notif-demo/commits/master to see how this demo
was set up.

If you have Docker installed, the `bin/` scripts can be used to setup and run the demo. If not, use PHP 7.2 with the GMP
extension, and Composer.

Run `composer install` to set up dependencies, `php artisan webpush:vapid` to generate a keypair for push subscriptions,
and `php artisan serve --host=0.0.0.0` to run the demo. (You can omit the `--host` argument if you're using native PHP.)
Access the demo at http://localhost:8000 and run `php artisan push:notif {title} {body}` to send a sample push
notification.
