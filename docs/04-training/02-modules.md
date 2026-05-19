# Modules

Each module has clear objectives, references into the codebase, and
pointer(s) to the matching exercise(s).

## Table of Contents

- [Module 1 — Environment & Tooling](#module-1--environment--tooling)
- [Module 2 — Laravel Walkthrough](#module-2--laravel-walkthrough)
- [Module 3 — Routing, Controllers, Views](#module-3--routing-controllers-views)
- [Module 4 — Eloquent & Migrations](#module-4--eloquent--migrations)
- [Module 5 — Validation & Form Requests](#module-5--validation--form-requests)
- [Module 6 — Livewire & Flux UI](#module-6--livewire--flux-ui)
- [Module 7 — Auth, 2FA & Passkeys](#module-7--auth-2fa--passkeys)
- [Module 8 — Testing with Pest](#module-8--testing-with-pest)
- [Module 9 — Git, PRs & Code Review](#module-9--git-prs--code-review)
- [Module 10 — Going Live](#module-10--going-live)

---

## Module 1 — Environment & Tooling

**Objective**: Every trainee has a working dev environment.

- Install PHP 8.3+, Composer, Node.js 20+, Git.
- Clone the repo, run `composer setup`, run `composer dev`.
- Register a user, visit `/dashboard`, `/settings/profile`.

**Reference**: [`02-development/01-getting-started.md`](../02-development/01-getting-started.md).

**Exercise**: Exercise 1.1 — *First Run*.

## Module 2 — Laravel Walkthrough

**Objective**: Map the codebase in your head.

- Walk through the directory structure.
- Trace one HTTP request from URL → response.
- Run `php artisan route:list` and identify each route's handler.

**Reference**: [`01-architecture/01-overview.md`](../01-architecture/01-overview.md).

**Exercise**: Exercise 2.1 — *Map the Routes*.

## Module 3 — Routing, Controllers, Views

**Objective**: Add a new resource.

- Study `UserController` and the matching views in `resources/views/users/`.
- Understand `Route::resource()`, route model binding, and named routes.
- Learn Blade basics: directives, layouts, partials.

**Reference**: [`01-architecture/02-patterns.md`](../01-architecture/02-patterns.md).

**Exercise**: Exercise 3.1 — *Implement `UserController@store`*.

## Module 4 — Eloquent & Migrations

**Objective**: Model and persist data.

- Generate a migration; understand schema builders.
- Define an Eloquent model with attributes (`#[Fillable]`, `#[Hidden]`, casts).
- Use Tinker to create, query, update, and delete rows.
- Build a factory and seeder.

**Reference**: [`01-architecture/03-data-layer.md`](../01-architecture/03-data-layer.md).

**Exercise**: Exercise 4.1 — *Add a `Post` model and migration*.

## Module 5 — Validation & Form Requests

**Objective**: Validate input cleanly.

- Inline `$request->validate([...])` vs. dedicated Form Requests.
- Generate `StoreUserRequest` and `UpdateUserRequest`.
- Display validation errors in Blade and Livewire.

**Reference**: Laravel docs on [Form Request Validation](https://laravel.com/docs/validation#form-request-validation).

**Exercise**: Exercise 5.1 — *Replace inline validation with Form Requests*.

## Module 6 — Livewire & Flux UI

**Objective**: Build interactive UI without writing JS.

- Examine `App\Livewire\Settings\Profile` end-to-end.
- Understand `wire:model`, `wire:click`, `wire:submit`, and lifecycle hooks.
- Use Flux primitives (`flux:card`, `flux:input`, `flux:button`, `flux:toast`).

**References**:
[`01-architecture/02-patterns.md`](../01-architecture/02-patterns.md),
[Livewire docs](https://livewire.laravel.com),
[Flux UI](https://fluxui.dev).

**Exercise**: Exercise 6.1 — *Convert the users index to a Livewire component*.

## Module 7 — Auth, 2FA & Passkeys

**Objective**: Understand auth flows and customise them.

- Walk through Fortify configuration and action classes.
- Enable / disable 2FA in `/settings/security`.
- Register a Passkey and log in with it.
- Extend a Fortify action (e.g. additional fields at registration).

**Reference**: [Laravel Fortify](https://laravel.com/docs/fortify), `app/Actions/Fortify/`.

**Exercise**: Exercise 7.1 — *Add a `phone` field to registration*.

## Module 8 — Testing with Pest

**Objective**: Catch regressions before users do.

- Run the existing suite; read each test.
- Write feature tests for the users resource.
- Write a Livewire interaction test.

**Reference**: [`02-development/03-testing.md`](../02-development/03-testing.md).

**Exercise**: Exercise 8.1 — *Cover the users resource with tests*.

## Module 9 — Git, PRs & Code Review

**Objective**: Collaborate like a professional team.

- Branch naming, conventional commits.
- Open a PR, request review, address comments.
- Review a peer's PR — leave at least two constructive comments.

**Reference**: [`02-development/02-workflows.md`](../02-development/02-workflows.md).

**Exercise**: Exercise 9.1 — *Peer-review another trainee's PR*.

## Module 10 — Going Live

**Objective**: Ship your capstone.

- Production checklist; what changes between local and production.
- Build assets, cache config/routes/views.
- Deploy to a free / cheap host.
- Smoke-test the live URL.

**Reference**: [`03-deployment/01-environments.md`](../03-deployment/01-environments.md).

**Exercise**: Exercise 10.1 — *Deploy your capstone*.
