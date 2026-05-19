# Exercises

Hands-on tasks paired with each module. Each exercise has clear
**acceptance criteria** so trainees know when they're done.

## Table of Contents

- [How to Submit](#how-to-submit)
- [Exercise 1.1 — First Run](#exercise-11--first-run)
- [Exercise 2.1 — Map the Routes](#exercise-21--map-the-routes)
- [Exercise 3.1 — Implement `UserController@store`](#exercise-31--implement-usercontrollerstore)
- [Exercise 4.1 — Add a `Post` model and migration](#exercise-41--add-a-post-model-and-migration)
- [Exercise 5.1 — Replace inline validation with Form Requests](#exercise-51--replace-inline-validation-with-form-requests)
- [Exercise 6.1 — Convert the users index to a Livewire component](#exercise-61--convert-the-users-index-to-a-livewire-component)
- [Exercise 7.1 — Add a `phone` field to registration](#exercise-71--add-a-phone-field-to-registration)
- [Exercise 8.1 — Cover the users resource with tests](#exercise-81--cover-the-users-resource-with-tests)
- [Exercise 9.1 — Peer-review another trainee's PR](#exercise-91--peer-review-another-trainees-pr)
- [Exercise 10.1 — Deploy your capstone](#exercise-101--deploy-your-capstone)

## How to Submit

1. Create a branch named `exercise/<module>-<n>-<short-slug>`, e.g. `exercise/3-1-user-store`.
2. Implement the work; add tests.
3. Run `composer lint` and `composer test`.
4. Push and open a PR against `main` with the exercise ID in the title.
5. Tag a facilitator for review.

---

## Exercise 1.1 — First Run

**Goal**: Prove your environment works.

**Acceptance criteria:**

- [ ] `composer dev` starts without errors.
- [ ] You can register a user and reach `/dashboard`.
- [ ] `composer test` passes locally.
- [ ] Submit a PR that updates `docs/04-training/04-resources.md`
      adding your name + handle to the "Cohort" section.

---

## Exercise 2.1 — Map the Routes

**Goal**: Demonstrate you can navigate the codebase.

**Acceptance criteria:**

- [ ] Run `php artisan route:list` and capture the output.
- [ ] In your PR description, list **every** route and its handler (controller class or Livewire component).
- [ ] Pick **one** route and write 3–5 sentences explaining how its request flows through the system.

---

## Exercise 3.1 — Implement `UserController@store`

**Goal**: Complete the users resource's create flow.

**Acceptance criteria:**

- [ ] `store()` accepts `name`, `email`, `password`.
- [ ] Validation enforces: `name` required string max:255,
      `email` required email unique:users,
      `password` required min:8 confirmed.
- [ ] Successful create redirects to `users.show` with a flash success.
- [ ] `resources/views/users/create.blade.php` posts to `route('users.store')` and shows validation errors.
- [ ] At least one Pest feature test covers the happy path.

---

## Exercise 4.1 — Add a `Post` model and migration

**Goal**: Practise schema + Eloquent.

**Acceptance criteria:**

- [ ] Migration creates `posts` (`id`, `user_id` FK, `title`, `body`, timestamps).
- [ ] `Post` model has `#[Fillable]` for title and body.
- [ ] `User hasMany Post` and `Post belongsTo User` relations work in Tinker.
- [ ] `PostFactory` produces valid fake data.
- [ ] `DatabaseSeeder` seeds 3 users with 5 posts each.

---

## Exercise 5.1 — Replace inline validation with Form Requests

**Goal**: Move validation rules out of controllers.

**Acceptance criteria:**

- [ ] `StoreUserRequest` and `UpdateUserRequest` exist under `app/Http/Requests/`.
- [ ] `UserController@store` and `@update` type-hint them instead of `Request`.
- [ ] Rules unchanged in behaviour.
- [ ] Custom error messages live in `messages()`.
- [ ] Existing tests still pass.

---

## Exercise 6.1 — Convert the users index to a Livewire component

**Goal**: Replace a static Blade page with a Livewire one.

**Acceptance criteria:**

- [ ] `App\Livewire\Users\Index` component exists.
- [ ] Route changed from `Route::resource(...)` index to a `Route::livewire(...)`.
- [ ] Page supports a `$search` property that filters by `name` or `email` live as you type.
- [ ] At least 10 users seeded — list paginates 5 per page.
- [ ] Uses Flux UI primitives for inputs and the table.

---

## Exercise 7.1 — Add a `phone` field to registration

**Goal**: Customise a Fortify flow.

**Acceptance criteria:**

- [ ] Migration adds `phone` to `users` (nullable string).
- [ ] `phone` added to `#[Fillable]` on `User`.
- [ ] Registration form (Fortify view) collects `phone`.
- [ ] `CreateNewUser` action in `app/Actions/Fortify/` validates and stores `phone`.
- [ ] `phone` shown in `/settings/profile`.

---

## Exercise 8.1 — Cover the users resource with tests

**Goal**: Prove the users resource works.

**Acceptance criteria:**

- [ ] At least one feature test per resource action (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
- [ ] Authorisation: unauthenticated users redirected to login.
- [ ] Validation: invalid `store` payload returns 422 with error fields.
- [ ] Test for the deletion-confirmation flow.
- [ ] `composer test` green.

---

## Exercise 9.1 — Peer-review another trainee's PR

**Goal**: Practise collaborative review.

**Acceptance criteria:**

- [ ] Leave at least 2 constructive review comments on a peer's open PR.
- [ ] At least one comment must reference a concrete improvement (style, test gap, naming, perf).
- [ ] Be kind. Critique the code, not the person.

---

## Exercise 10.1 — Deploy your capstone

**Goal**: Take it live.

**Acceptance criteria:**

- [ ] App deployed to a public URL (Laravel Cloud, Forge, Railway, Fly.io — your choice).
- [ ] `APP_DEBUG=false` in production.
- [ ] HTTPS enabled.
- [ ] You can register, log in, and use one core feature on the live URL.
- [ ] Submit a PR adding your live URL + brief deploy notes to `docs/04-training/04-resources.md`.
