# AdventureX Installation Guide

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 22+
- MySQL 8+
- Nginx
- Git

## Steps

1. Clone the repository
2. Run `composer install --no-dev --optimize-autoloader`
3. Copy `.env` to `.env` and update database credentials
4. Run `php artisan key:generate`
5. Run `php artisan migrate --force`
6. Run `php artisan storage:link`
7. Run `npm install && npm run build`
8. Run `php artisan optimize`
9. Configure Nginx virtual host
10. Set up SSL with Let's Encrypt
11. Start queue worker with Supervisor
12. Add cron job: `* * * * * php /path/to/artisan schedule:run`

## Environment Variables

See `.env.example` for required variables.
