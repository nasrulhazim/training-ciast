# Getting Started

Get the project running on your machine in under five minutes.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Install](#install)
- [Configure Environment](#configure-environment)
- [Initialise the Database](#initialise-the-database)
- [Run the Dev Stack](#run-the-dev-stack)
- [Verify Your Setup](#verify-your-setup)
- [Troubleshooting](#troubleshooting)

## Prerequisites

| Tool | Version | Why |
|------|---------|-----|
| PHP | 8.3 or newer | Laravel 13 requires it. |
| Composer | 2.x | PHP package manager. |
| Node.js | 20 LTS or newer | Vite + Tailwind build. |
| npm | bundled with Node | JS dependencies. |
| SQLite | bundled with PHP | Default DB driver. |
| Git | any recent version | Source control. |

Check versions:

```bash
php -v
composer --version
node -v
npm -v
git --version
```

## Install

Clone the repo and install dependencies:

```bash
git clone <repo-url> graduation
cd graduation

composer install
npm install
```

> **Tip**: there's a shortcut — `composer setup` runs install, env copy,
> key gen, migrate, npm install, and the initial build in one go.

## Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Useful keys in `.env` (already sensible defaults):

| Key | Default | Notes |
|-----|---------|-------|
| `APP_NAME` | `Laravel` | Change to your project name. |
| `APP_URL` | `http://localhost` | Match the URL you'll use. |
| `DB_CONNECTION` | `sqlite` | No host/user/pass required. |
| `MAIL_MAILER` | `log` | Emails are written to `storage/logs/laravel.log`. |
| `SESSION_DRIVER` | `database` | Sessions stored in the `sessions` table. |
| `QUEUE_CONNECTION` | `database` | Jobs stored in the `jobs` table. |
| `CACHE_STORE` | `database` | Cache stored in the `cache` table. |

## Initialise the Database

```bash
touch database/database.sqlite
php artisan migrate
```

If you want some seeded data later:

```bash
php artisan migrate:fresh --seed
```

## Run the Dev Stack

The starter kit exposes a single `composer dev` command that runs four
processes concurrently:

```bash
composer dev
```

| Process | What it does |
|---------|-------------|
| `php artisan serve` | HTTP server on <http://localhost:8000> |
| `php artisan queue:listen` | Processes queued jobs. |
| `php artisan pail` | Streams logs to the terminal. |
| `npm run dev` (Vite) | Builds CSS/JS and hot-reloads on changes. |

> **Note**: `composer dev` uses `concurrently` (a JS dep) — make sure
> `npm install` ran successfully first.

If you'd rather run them in separate terminals:

```bash
# terminal 1
php artisan serve

# terminal 2
php artisan queue:listen

# terminal 3
npm run dev
```

## Verify Your Setup

1. Open <http://localhost:8000> — you should see the welcome page.
2. Click **Register** and create a test account.
3. After registration you should land on `/dashboard`.
4. Visit `/settings/profile` and `/settings/security` to confirm
   Livewire + Flux UI render correctly.
5. Run the test suite:

   ```bash
   composer test
   ```

   All tests should pass.

## Troubleshooting

| Symptom | Likely cause | Fix |
|---------|-------------|-----|
| `SQLSTATE[HY000]: General error: 1 unable to open database file` | `database/database.sqlite` missing. | `touch database/database.sqlite` then re-run `php artisan migrate`. |
| `Class "App\..." not found` | Autoload cache stale. | `composer dump-autoload`. |
| Vite assets 404 in the browser | `npm run dev` not running. | Start it or run `npm run build` for a static build. |
| `Class "Pest\..." not found` | Pest plugin not installed. | `composer install` (dev deps). |
| Permission denied writing logs | `storage/` not writable. | `chmod -R 775 storage bootstrap/cache`. |
| `php artisan key:generate` fails | `.env` missing. | `cp .env.example .env`. |
