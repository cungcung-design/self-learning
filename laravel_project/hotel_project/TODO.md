# TODO

- [ ] Identify why user session is being invalidated after booking (likely auth/session middleware / Jetstream)
- [ ] Inspect booking POST handler and ensure notification errors never cause auth fallback redirects
- [ ] Harden `UserController@add_booking` to catch any Throwable and still redirect back without touching session/auth
- [ ] Run Laravel tests / manual flow check
- [ ] Verify session remains logged in after successful booking and after email notification failures
