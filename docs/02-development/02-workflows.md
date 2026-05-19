# Daily Workflows

Common commands, branching, commit style, and code-quality rules used
during training.

## Table of Contents

- [Daily Commands](#daily-commands)
- [Branching](#branching)
- [Commit Messages](#commit-messages)
- [Code Style](#code-style)
- [Submitting Work (Pull Requests)](#submitting-work-pull-requests)
- [Useful Artisan Commands](#useful-artisan-commands)

## Daily Commands

| Goal | Command |
|------|---------|
| Start the dev stack | `composer dev` |
| Run all tests | `composer test` |
| Fix code style | `composer lint` |
| Check code style without fixing | `composer lint:check` |
| Open a Tinker REPL | `php artisan tinker` |
| Stream logs | `php artisan pail` |
| Rebuild front-end assets | `npm run build` |
| Reset the database | `php artisan migrate:fresh --seed` |

## Branching

Use **short-lived feature branches** off `main`. Suggested naming:

```text
feature/<short-name>     # new feature work
fix/<short-name>         # bug fixes
chore/<short-name>       # tooling / docs / cleanup
exercise/<module>-<n>    # training exercise submissions
```

Examples:

```text
feature/user-store-action
fix/security-page-2fa-disable
exercise/module-3-form-requests
```

## Commit Messages

Use **conventional commit** style — short, lowercase, imperative:

```text
<type>: <summary>

[optional body explaining *why*, not what]
```

Common types: `feat`, `fix`, `chore`, `docs`, `refactor`, `test`, `style`.

Examples:

```text
feat: add UserController@store with validation
fix: prevent deleting the last admin user
test: cover users.index route auth requirement
docs: explain Fortify customisation points
```

## Code Style

The project uses **Laravel Pint** (PHP-CS-Fixer wrapper) configured in
`pint.json`.

Always run before pushing:

```bash
composer lint
```

This formats files **in place**. CI (and `composer test`) will fail if
the style check doesn't pass — `composer test` runs `lint:check` before
the test suite.

## Submitting Work (Pull Requests)

1. Branch off `main`:

   ```bash
   git checkout main && git pull
   git checkout -b exercise/module-3-form-requests
   ```

2. Make changes; commit in small, meaningful chunks.
3. Run quality gates locally:

   ```bash
   composer lint
   composer test
   ```

4. Push and open a PR against `main` with:

   - A descriptive title (conventional commit style is fine).
   - Which exercise / module this addresses.
   - How you verified it works (commands, screenshots).

5. Facilitators will review and either merge or request changes.

## Useful Artisan Commands

| Command | Purpose |
|---------|---------|
| `php artisan route:list` | See every registered route. |
| `php artisan make:controller PostController --resource` | Resource controller skeleton. |
| `php artisan make:model Post -mfs` | Model + migration + factory + seeder. |
| `php artisan make:request StoreUserRequest` | Form Request for validation. |
| `php artisan make:livewire Users/Create` | Livewire component + view. |
| `php artisan make:test UserStoreTest --pest` | Pest feature test. |
| `php artisan db:show` | Summary of DB connection + tables. |
| `php artisan db:table users` | Schema + row count for a table. |
| `php artisan about` | Versions of everything Laravel knows about. |
