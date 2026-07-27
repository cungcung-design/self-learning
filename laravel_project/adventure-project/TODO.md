# TODO: Fix Home.vue & Create Empty Section Components

## Steps
- [x] 1. Fix `Home.vue` — update imports to `@/Pages/User/*` and add all 7 sections
- [x] 2. Create `StatsSection.vue` — stats/counters section
- [x] 3. Create `CategorySection.vue` — category cards grid
- [x] 4. Create `WhyChooseSection.vue` — "Why Choose Us" feature cards
- [x] 5. Create `TestimonialSection.vue` — testimonial/review cards
- [x] 6. Create `CTASection.vue` — call-to-action banner

---

# TODO: Fix Payment Checkout Flow

## Steps
- [x] 1. Remove duplicate `/payment/{booking}` route from `web.php`
- [x] 2. Add booking ownership authorization to `PaymentController@checkout`
- [x] 3. Add booking ownership authorization to `PaymentController@process`

---

# TODO: Fix Favorites Feature

## Steps
- [x] 1. Update `FavoriteController` — add `store(Adventure)` and `destroy(Adventure)` with route model binding
- [x] 2. Fix `routes/web.php` — clean up duplicate/broken routes, add proper store/destroy
- [x] 3. Update `AdventureCard.vue` — wire 🤍 button with `router.post`

---

# TODO: Fix Review Feature (Broken)

## Steps
- [x] 1. Fix `ReviewController.php` — fix `adenture_id` typo, use `auth()->id()`, add route model binding
- [x] 2. Create `ReviewForm.vue` — working review form with rating stars
- [x] 3. Fix route — already had `{adventure}` binding
- [x] 4. Update `AdventureDetail.vue` — import and render `ReviewForm`
- [x] 5. Verify the whole flow works end-to-end

