#!/bin/sh

echo "Run supervisord"
supervisord -c /etc/supervisor/supervisord.conf

echo "Run schedule"
php artisan schedule:work

exec "$@"
