# Testing

This project uses **Pest 4** with the Pest Plugin Laravel. Tests live
under `tests/Feature/` and `tests/Unit/`.

## Table of Contents

- [Running Tests](#running-tests)
- [Test Structure](#test-structure)
- [Writing a Feature Test](#writing-a-feature-test)
- [Writing a Unit Test](#writing-a-unit-test)
- [Database in Tests](#database-in-tests)
- [Testing Livewire Components](#testing-livewire-components)
- [Coverage Expectations](#coverage-expectations)

## Running Tests

| Command | Purpose |
|---------|---------|
| `composer test` | Lint check + full Pest suite. |
| `php artisan test` | Pest suite only. |
| `php artisan test --filter=UserStoreTest` | Run one test file. |
| `php artisan test --parallel` | Parallel run (faster on multi-core). |
| `php artisan test --coverage` | Coverage report (requires Xdebug or PCOV). |

## Test Structure

```text
tests/
├── Feature/
│   ├── Auth/              # Login, register, password reset flows
│   ├── Settings/          # Settings page tests
│   ├── DashboardTest.php  # Dashboard auth + render
│   └── ExampleTest.php
├── Unit/
│   └── ExampleTest.php
├── Pest.php               # Global Pest config (test case + traits)
└── TestCase.php           # Base test case
```

- **Feature tests** boot the app and exercise routes / Livewire
  components end-to-end. Use these for most things.
- **Unit tests** test a single class in isolation. Reach for these for
  pure functions or value objects.

## Writing a Feature Test

```php
<?php

use App\Models\User;

it('lists users on the index page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('users.index'))
        ->assertOk()
        ->assertSee($user->name);
});

it('requires authentication to view users', function () {
    $this->get(route('users.index'))
        ->assertRedirect(route('login'));
});
```

Pest helpers used here: `it()`, `actingAs()`, fluent response assertions.

## Writing a Unit Test

```php
<?php

use App\Models\User;

it('builds initials from the user name', function () {
    $user = new User(['name' => 'Ada Lovelace']);

    expect($user->initials())->toBe('AL');
});
```

## Database in Tests

`phpunit.xml` sets the DB to in-memory SQLite for tests:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

Add the `RefreshDatabase` trait when a test touches the DB:

```php
uses(Illuminate\Foundation\Testing\RefreshDatabase::class);
```

> **Tip**: register it once in `tests/Pest.php` to apply across files:
>
> ```php
> uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');
> ```

## Testing Livewire Components

```php
<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

it('updates the profile name', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Profile::class)
        ->set('name', 'New Name')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->name)->toBe('New Name');
});
```

## Coverage Expectations

For the training programme:

| Code | Required tests |
|------|---------------|
| New controller method | Happy-path feature test + auth/validation tests. |
| New Livewire component | At least one render test + one interaction test. |
| New model behaviour | Unit test for any non-trivial method. |
| Bug fix | Regression test that fails before the fix and passes after. |

Trainees should aim for **every PR to add at least one test**.
