# Edit plan (Login/Register duplicated in `resources/views/home/header.blade.php`)

## Information Gathered

- `resources/views/home/header.blade.php` contains duplicated Login/Register UI blocks:
    - One unconditional “Login”/“Register” button using `route('login')` and `route('register')`.
    - Another conditional block using `Route::has('login')`, `@auth`, `@else`, and another nested `Route::has('register')`.
    - Logged-in state renders `<x-app-layout></x-app-layout>` inside the `<ul>`, which is not appropriate for a nav button and also causes layout duplication.

## Plan

### File: `resources/views/home/header.blade.php`

1. Remove the unconditional Login/Register `<li>` entries (the ones before `@if (Route::has('login'))`).
2. Replace the whole duplicated conditional section with a single clean authentication section:
    - Use `@auth` to show a single “Dashboard” (or a profile link) when logged in.
    - Use `@guest` to show single “Login” and “Register” buttons when not logged in.
3. Keep the existing `route('login')` / `route('register')` links for guest buttons.
4. Avoid rendering Jetstream layout components (`<x-app-layout>`) inside the nav.

## Dependent Files to be edited

- None (only header will be changed).

## Followup steps

- Check Blade syntax by running: `php artisan view:clear`.
- If desired, run `php artisan serve` and open any home page to confirm only one Login/Register area appears.
