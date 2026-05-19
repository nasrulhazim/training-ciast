# Patterns & Conventions

The repeating shapes used across the codebase. When you add a feature,
follow these patterns so the project stays consistent.

## Table of Contents

- [Route Registration](#route-registration)
- [Controllers (Resource Pattern)](#controllers-resource-pattern)
- [Livewire Components](#livewire-components)
- [Flux UI Components](#flux-ui-components)
- [Fortify Customisation](#fortify-customisation)
- [Eloquent Attribute Conventions](#eloquent-attribute-conventions)
- [Blade View Organisation](#blade-view-organisation)

## Route Registration

The app uses **three** route registration styles depending on intent:

| Style | Used for | Example |
|-------|----------|---------|
| `Route::view(...)` | Static Blade pages (no controller logic) | `Route::view('/', 'welcome')->name('home');` |
| `Route::resource(...)` | Traditional REST resources | `Route::resource('users', UserController::class);` |
| `Route::livewire(...)` | Full-page Livewire components | `Route::livewire('settings/profile', Profile::class)->name('profile.edit');` |

Routes are split by concern:

- `routes/web.php` — public pages, authenticated dashboard, users resource.
- `routes/settings.php` — settings pages (mounted via `require` from `web.php`).

## Controllers (Resource Pattern)

Controllers extend `App\Http\Controllers\Controller` and follow Laravel's
**resource controller** convention. See `app/Http/Controllers/UserController.php`:

```php
public function index()
{
    $users = User::get();
    return view('users.index', compact('users'));
}

public function show(User $user)
{
    return view('users.show', compact('user'));
}
```

Conventions:

- Use **route model binding** (`User $user`) for show/edit/update/destroy.
- Keep controllers **thin** — push validation into Form Requests and
  business logic into Action classes (trainees will add these).
- View names mirror the resource: `users.index`, `users.show`, etc.

## Livewire Components

Each Livewire component is a class in `app/Livewire/...` plus a Blade
view in `resources/views/livewire/...`. Reusable actions (like `Logout`)
live under `app/Livewire/Actions/`.

Examples in this codebase:

| Class | Purpose |
|-------|---------|
| `App\Livewire\Settings\Profile` | Edit profile (name, email). |
| `App\Livewire\Settings\Security` | Change password, manage passkeys & 2FA. |
| `App\Livewire\Settings\Appearance` | Pick light / dark / system theme. |
| `App\Livewire\Settings\DeleteUserForm` | Delete-account confirmation. |
| `App\Livewire\Actions\Logout` | Log out the current session. |

Full-page Livewire components are mounted with `Route::livewire(...)`.

## Flux UI Components

The UI is built on [Flux UI](https://fluxui.dev) — a first-party Livewire
component library. Templates use `<flux:*>` tags:

```blade
<flux:card>
    <flux:heading>Profile</flux:heading>
    <flux:input wire:model="name" label="Name" />
    <flux:button type="submit">Save</flux:button>
</flux:card>
```

Flux primitives used here: `card`, `input`, `button`, `heading`, `badge`,
`toast`, plus layout helpers. See `resources/views/flux/` and
`resources/views/livewire/settings/`.

## Fortify Customisation

Laravel Fortify provides the auth backend. The starter kit registers
custom action classes under `app/Actions/Fortify/`. The `User` model
implements Fortify contracts:

```php
class User extends Authenticatable implements PasskeyUser
{
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;
}
```

When you customise registration, password reset, or profile update,
edit (or add) the matching Fortify action class — don't write your own
controllers for those flows.

## Eloquent Attribute Conventions

This codebase uses Laravel's **attribute-based model configuration**
(new in recent Laravel versions). See `app/Models/User.php`:

```php
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

Use `#[Fillable]` and `#[Hidden]` attributes instead of the older
`$fillable` / `$hidden` properties when adding new models.

## Blade View Organisation

```text
resources/views/
├── components/      # Anonymous + class Blade components
├── flux/            # Flux UI overrides / extensions
├── layouts/         # App + auth + settings layouts
├── livewire/        # Livewire component templates
├── partials/        # Shared partials (nav, etc.)
├── users/           # Users resource views (index/create/show/edit)
├── dashboard.blade.php
└── welcome.blade.php
```

Naming rule: resource views live in a folder named after the resource
(`users/`), and full-page Livewire views live under `livewire/...`
mirroring the class namespace.
