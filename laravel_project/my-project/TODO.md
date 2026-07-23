# TODO

## Goal: Fix missing UI pages for /users routes

- [ ] Inspect controller/view mapping (UserController + existing Blade files)
- [ ] Implement fix: either move Blade files into `resources/views/users/` OR change controller view names to match existing files
- [ ] Fix controller class imports and request handling (User model, Request facade)
- [ ] Update route parameter typo (`/users/{id}edit`) if needed
- [ ] Run `php artisan route:list` and manually verify routes return HTML
