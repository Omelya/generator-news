echo "Run migrations"
php artisan migrate

echo "Run supervisord"
supervisord -c /etc/supervisor/supervisord.conf

echo "Run cron"
php artisan schedule:work
