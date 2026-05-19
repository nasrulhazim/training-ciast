# Environments

A reference for how this app behaves across environments and what to
change before exposing it beyond `localhost`.

## Table of Contents

- [Environment Matrix](#environment-matrix)
- [Pre-Deploy Checklist](#pre-deploy-checklist)
- [`.env` Differences](#env-differences)
- [Production Cache Commands](#production-cache-commands)
- [Hosting Options Trainees Can Try](#hosting-options-trainees-can-try)

## Environment Matrix

| Concern | Local (training) | Staging / Production |
|---------|------------------|----------------------|
| `APP_ENV` | `local` | `staging` / `production` |
| `APP_DEBUG` | `true` | **`false`** |
| `APP_URL` | `http://localhost:8000` | Public HTTPS URL |
| DB | SQLite file | MySQL / Postgres |
| Mail | `log` driver | SMTP / Mailgun / SES |
| Queue | `database` | `redis` or `database` with a daemon |
| Cache | `database` | `redis` (recommended) |
| Sessions | `database` | `redis` or `database` |
| Asset build | `npm run dev` (Vite HMR) | `npm run build` (static) |
| Logs | `single` file | `daily` or `papertrail` / `stack` |

## Pre-Deploy Checklist

Before promoting code beyond your laptop:

- [ ] `APP_DEBUG=false` in the target `.env`.
- [ ] `APP_KEY` generated for the target environment (`php artisan key:generate`).
- [ ] DB credentials configured and migrations run (`php artisan migrate --force`).
- [ ] Front-end assets built (`npm run build`).
- [ ] HTTPS enforced (terminate at the load balancer / reverse proxy).
- [ ] Storage directory writable (`storage/`, `bootstrap/cache/`).
- [ ] `composer install --no-dev --optimize-autoloader`.
- [ ] Config + route + view caches warmed (see below).
- [ ] Queue worker running (e.g. `php artisan queue:work` under supervisord / systemd).

## `.env` Differences

Keys you almost always change for production:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.example

DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="no-reply@your-domain.example"
```

## Production Cache Commands

Run on every deploy after pulling new code:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

To clear them (e.g. while debugging):

```bash
php artisan optimize:clear
```

## Hosting Options Trainees Can Try

| Option | Best for |
|--------|---------|
| [Laravel Cloud](https://cloud.laravel.com) | One-click deploys, official Laravel hosting. |
| [Laravel Forge](https://forge.laravel.com) + DigitalOcean / Hetzner | Managed VPS provisioning. |
| Docker + any cloud | Self-hosted, full control. Sail (`composer require laravel/sail --dev`) is already available. |
| Railway / Fly.io | Quick demos. |

Trainees are encouraged to deploy their final exercise to a free / cheap
host as part of the **Going Live** module.
