# CIAST Graduation Training — Documentation

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=flat-square&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Flux UI](https://img.shields.io/badge/Flux_UI-2.x-000000?style=flat-square)](https://fluxui.dev)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Pest](https://img.shields.io/badge/Pest-4.x-AA55FF?style=flat-square)](https://pestphp.com)
[![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)](https://opensource.org/licenses/MIT)

Hands-on Laravel training project for the **CIAST Graduation 2026** cohort.
Built on the official **Laravel Livewire Starter Kit** so trainees can learn
modern Laravel by extending a real, production-shaped codebase.

## Table of Contents

- [About This Training](#about-this-training)
- [Quick Start](#quick-start)
- [Documentation Map](#documentation-map)
- [Learning Path](#learning-path)
- [Project Stack](#project-stack)
- [Conventions](#conventions)

## About This Training

This repository is the working codebase for trainees during the CIAST
graduation programme. It demonstrates a complete, opinionated Laravel
application — authentication, two-factor, passkeys, settings, and a
basic users CRUD — and is intentionally **left incomplete** in spots so
trainees can finish features as exercises.

See [`04-training/`](04-training/README.md) for the syllabus, modules,
and exercise list.

## Quick Start

```bash
# 1. Install dependencies
composer install
npm install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Set up the database (SQLite by default)
touch database/database.sqlite
php artisan migrate

# 4. Run the dev stack (server + queue + logs + vite)
composer dev
```

Open <http://localhost:8000> and register an account to start exploring.

Full setup details: [`02-development/01-getting-started.md`](02-development/01-getting-started.md).

## Documentation Map

```mermaid
graph TD
    root["docs/"]
    root --> arch["01-architecture/"]
    root --> dev["02-development/"]
    root --> deploy["03-deployment/"]
    root --> train["04-training/"]

    arch --> a1["01-overview.md"]
    arch --> a2["02-patterns.md"]
    arch --> a3["03-data-layer.md"]

    dev --> d1["01-getting-started.md"]
    dev --> d2["02-workflows.md"]
    dev --> d3["03-testing.md"]

    deploy --> p1["01-environments.md"]

    train --> t1["01-syllabus.md"]
    train --> t2["02-modules.md"]
    train --> t3["03-exercises.md"]
    train --> t4["04-resources.md"]

    style root fill:#e1f5fe
    style arch fill:#e8f5e9
    style dev fill:#fff3e0
    style deploy fill:#fce4ec
    style train fill:#f3e5f5
```

| Section | Purpose |
|---------|---------|
| [01-architecture](01-architecture/README.md) | How the app is structured — request flow, layers, patterns, data model. |
| [02-development](02-development/README.md) | Local setup, daily workflow, and testing. |
| [03-deployment](03-deployment/README.md) | Environments and deployment notes. |
| [04-training](04-training/README.md) | Syllabus, training modules, exercises, and reference material. |

## Learning Path

Recommended reading order for trainees:

1. [Getting Started](02-development/01-getting-started.md) — get the app running.
2. [Architecture Overview](01-architecture/01-overview.md) — understand the layout.
3. [Training Syllabus](04-training/01-syllabus.md) — see the full programme.
4. [Modules](04-training/02-modules.md) — work through each module.
5. [Exercises](04-training/03-exercises.md) — apply what you've learned.
6. [Testing](02-development/03-testing.md) — write Pest tests for your changes.

## Project Stack

| Layer | Technology |
|-------|-----------|
| Language | PHP 8.3+ |
| Framework | Laravel 13 |
| Frontend | Livewire 4 + Flux UI 2 + Tailwind CSS 4 |
| Auth | Laravel Fortify (with Passkeys + 2FA) |
| Build | Vite 7 |
| Testing | Pest 4 + Pest Plugin Laravel |
| Database | SQLite (dev) — Migrations only |
| Tooling | Laravel Pint, Pail, Sail, Tinker |

## Conventions

- Branch naming, commit style, and PR flow: see [02-development/02-workflows.md](02-development/02-workflows.md).
- Code style enforced by **Laravel Pint** — run `composer lint` before
  committing.
- Tests must pass before merging — `composer test`.
- Trainees should follow the exercise spec in `04-training/03-exercises.md`
  and submit work as pull requests against `main`.

---

Maintained by the CIAST training facilitators. Contributions from trainees welcome.
