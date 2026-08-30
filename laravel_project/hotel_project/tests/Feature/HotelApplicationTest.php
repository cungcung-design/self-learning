<?php

namespace Tests\Feature;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\FeaturedCategory;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use App\Notifications\BookingReceivedNotification;
use App\Notifications\BookingStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class HotelApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_the_home_page(): void
    {
        Room::factory()->create(['room_name' => 'Ocean Suite']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Ocean Suite');
    }

    public function test_guests_can_submit_the_contact_form(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jane Guest',
            'email' => 'jane@example.com',
            'phone' => '0123456789',
            'message' => 'I would like to know more about weekend availability.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contacts', [
            'email' => 'jane@example.com',
            'name' => 'Jane Guest',
        ]);
    }

    public function test_contact_form_requires_valid_data(): void
    {
        $response = $this->from('/')->post(route('contact.store'), []);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message']);
    }

    public function test_guests_cannot_book_a_room(): void
    {
        $room = Room::factory()->create();

        $response = $this->post(route('bookings.store', $room), [
            'name' => 'Jane Guest',
            'email' => 'jane@example.com',
            'phone' => '0123456789',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_authenticated_users_can_book_an_available_room(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)->post(route('bookings.store', $room), [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '0123456789',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('message');
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'status' => Booking::STATUS_PENDING,
        ]);

        Notification::assertSentTo($user, BookingReceivedNotification::class);
    }

    public function test_overlapping_bookings_are_rejected(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => Booking::STATUS_PENDING,
        ]);

        $response = $this->actingAs($user)->from(route('rooms.show', $room))->post(route('bookings.store', $room), [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '0123456789',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
        ]);

        $response->assertRedirect(route('rooms.show', $room));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('bookings', 1);
    }

    public function test_regular_users_cannot_access_the_admin_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('home.public'));
    }

    public function test_admins_can_create_and_delete_rooms(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.rooms.store'), [
            'room_name' => 'Garden View',
            'room_description' => 'Quiet room overlooking the garden.',
            'room_price' => 120,
            'room_wifi' => 'yes',
            'room_type' => 'premium',
        ])->assertRedirect(route('admin.rooms.index'));

        $room = Room::query()->where('room_name', 'Garden View')->first();
        $this->assertNotNull($room);

        $this->actingAs($admin)
            ->delete(route('admin.rooms.destroy', $room))
            ->assertRedirect();

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_admins_can_approve_bookings(): void
    {
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $booking = Booking::factory()->create(['status' => Booking::STATUS_PENDING]);

        $this->actingAs($admin)
            ->post(route('admin.bookings.approve', $booking))
            ->assertRedirect();

        $this->assertSame(Booking::STATUS_APPROVED, $booking->fresh()->status);
        Notification::assertSentTo($booking->user, BookingStatusNotification::class);
    }

    public function test_users_can_view_and_cancel_their_pending_bookings(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => Booking::STATUS_PENDING,
            'start_date' => now()->addDays(4)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
        ]);

        $this->actingAs($user)
            ->get(route('bookings.index'))
            ->assertOk()
            ->assertSee($booking->room->room_name);

        $this->actingAs($user)
            ->post(route('bookings.cancel', $booking))
            ->assertRedirect();

        $this->assertSame(Booking::STATUS_CANCELLED, $booking->fresh()->status);
    }

    public function test_users_cannot_cancel_someone_elses_booking(): void
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['status' => Booking::STATUS_PENDING]);

        $this->actingAs($user)
            ->post(route('bookings.cancel', $booking))
            ->assertForbidden();
    }

    public function test_cancelled_bookings_do_not_block_new_reservations(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $room = Room::factory()->create();

        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => Booking::STATUS_CANCELLED,
        ]);

        $this->actingAs($user)->post(route('bookings.store', $room), [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '0123456789',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
        ])->assertRedirect(route('bookings.index'));

        $this->assertDatabaseCount('bookings', 2);
    }

    public function test_availability_search_hides_booked_rooms(): void
    {
        $available = Room::factory()->create(['room_name' => 'Open Garden Room']);
        $booked = Room::factory()->create(['room_name' => 'Taken Lake Room']);

        Booking::factory()->create([
            'room_id' => $booked->id,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => Booking::STATUS_APPROVED,
        ]);

        $response = $this->get(route('home.public', [
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
        ]));

        $response->assertOk();
        $response->assertSee('Open Garden Room');
        $response->assertDontSee('Taken Lake Room');
        $response->assertSee($available->room_name);
    }

    public function test_guests_can_view_public_pages(): void
    {
        $room = Room::factory()->create(['room_name' => 'Harbour Suite']);

        $this->get(route('about'))->assertOk()->assertSee('About');
        $this->get(route('gallery'))->assertOk();
        $this->get(route('contact.show'))->assertOk()->assertSee('Send a message');
        $this->get(route('rooms.index'))->assertOk()->assertSee('Harbour Suite');
        $this->get(route('rooms.show', $room))
            ->assertOk()
            ->assertSee('Harbour Suite')
            ->assertSee('Log in to book')
            ->assertDontSee('Request booking');
    }

    public function test_featured_listings_loop_hotels_from_the_database(): void
    {
        $hotel = Hotel::query()->create([
            'name' => 'Palm Grove Test Hotel',
            'slug' => 'palm-grove-test-hotel',
            'price' => 199,
            'location' => 'Penang',
            'rating' => 4.6,
            'status' => 'active',
        ]);
        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
            'room_name' => 'Palm Grove King',
        ]);

        $this->get(route('featured.index'))
            ->assertOk()
            ->assertSee('Palm Grove Test Hotel')
            ->assertSee('Penang')
            ->assertSee(route('rooms.show', $room), false)
            ->assertDontSee('Grand Metro City Hotel');
    }

    public function test_featured_listings_carousel_uses_hotel_data(): void
    {
        foreach (range(1, 7) as $index) {
            Hotel::query()->create([
                'name' => sprintf('Carousel Hotel %02d', $index),
                'slug' => 'carousel-hotel-'.$index,
                'price' => 120 + $index,
                'location' => 'Kuala Lumpur',
                'rating' => 4.0,
                'status' => 'active',
            ]);
        }

        $this->get(route('featured.index'))
            ->assertOk()
            ->assertSee('Carousel Hotel 01')
            ->assertSee('Carousel Hotel 07')
            ->assertSee('Showing 1–4 of 7 stays')
            ->assertSee('data-carousel-prev', false)
            ->assertSee('data-carousel-next', false)
            ->assertSee('data-hotel-carousel', false);
    }

    public function test_featured_listings_category_filter_returns_json_fragment(): void
    {
        $category = FeaturedCategory::query()->create([
            'name' => 'Beachfront',
            'slug' => 'beachfront',
        ]);
        $matched = Hotel::query()->create([
            'name' => 'Shoreline Test Hotel',
            'slug' => 'shoreline-test-hotel',
            'location' => 'Langkawi',
            'price' => 180,
            'rating' => 4.5,
            'status' => 'active',
        ]);
        $matched->featuredCategories()->attach($category);
        Hotel::query()->create([
            'name' => 'City Center Test Hotel',
            'slug' => 'city-center-test-hotel',
            'location' => 'Kuala Lumpur',
            'price' => 150,
            'rating' => 4.2,
            'status' => 'active',
        ]);

        $response = $this->getJson(route('featured.index', ['category' => 'beachfront']));

        $response->assertOk()
            ->assertJsonPath('title', 'Beachfront Hotels')
            ->assertJsonPath('count', 1);

        $html = (string) $response->json('html');
        $this->assertStringContainsString('Shoreline Test Hotel', $html);
        $this->assertStringContainsString('Langkawi', $html);
        $this->assertStringNotContainsString('City Center Test Hotel', $html);
    }

    public function test_featured_listings_empty_category_returns_empty_state(): void
    {
        FeaturedCategory::query()->create([
            'name' => 'Quiet Retreats',
            'slug' => 'quiet-retreats',
        ]);

        $response = $this->getJson(route('featured.index', ['category' => 'quiet-retreats']));

        $response->assertOk()->assertJsonPath('count', 0);
        $this->assertStringContainsString(
            'No hotels are available in this collection yet.',
            (string) $response->json('html')
        );
    }

    public function test_room_details_loop_room_data_from_the_database(): void
    {
        $hotel = Hotel::query()->create([
            'name' => 'Harbour View Hotel',
            'slug' => 'harbour-view-hotel',
            'location' => 'Penang',
            'rating' => 4.7,
            'check_in_time' => '15:00',
            'check_out_time' => '11:00',
            'status' => 'active',
        ]);
        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
            'room_name' => 'Harbour Suite',
            'room_description' => 'A bright harbour-facing suite.',
            'room_price' => 275,
            'room_type' => 'suite',
            'max_guests' => 3,
            'beds' => 2,
            'bed_type' => 'King + Twin',
            'room_size' => '48 sqm',
            'room_wifi' => 'yes',
        ]);
        $amenity = Amenity::query()->create([
            'name' => 'Sea View',
            'slug' => 'sea-view',
            'icon' => 'fa fa-eye',
        ]);
        $room->roomAmenities()->attach($amenity->id);
        foreach (['images/rooms/king-1.jpg', 'images/rooms/family-1.jpg', 'images/rooms/family-2.jpg', 'images/rooms/ocean-1.jpg', 'images/rooms/features/bath-1.jpg', 'images/rooms/features/shower-1.jpg'] as $index => $path) {
            $room->roomImages()->create([
                'image_url' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index + 1,
            ]);
        }

        $this->actingAs(User::factory()->create())
            ->get(route('rooms.show', $room))
            ->assertOk()
            ->assertSee('Harbour Suite')
            ->assertSee('Harbour View Hotel')
            ->assertSee('Penang')
            ->assertSee('A bright harbour-facing suite.')
            ->assertSee('$275')
            ->assertSee('3 guests')
            ->assertSee('2 beds')
            ->assertSee('King + Twin')
            ->assertSee('48 sqm')
            ->assertSee('Sea View')
            ->assertSee('15:00')
            ->assertSee('11:00')
            ->assertSee('Harbour Suite — Main bedroom')
            ->assertSee('Harbour Suite — Bathroom')
            ->assertSee('shower-1.jpg')
            ->assertSee('Request booking')
            ->assertDontSee('Log in to book')
            ->assertDontSee('Virtual')
            ->assertDontSee('Price & Task history')
            ->assertDontSee('A comfortable hotel room with carefully selected photos');
    }

    public function test_room_listing_hides_unavailable_rooms(): void
    {
        Room::factory()->create(['room_name' => 'Open Garden Room']);
        $booked = Room::factory()->create(['room_name' => 'Taken Lake Room']);

        Booking::factory()->create([
            'room_id' => $booked->id,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => Booking::STATUS_APPROVED,
        ]);

        $this->get(route('rooms.index', [
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
        ]))
            ->assertOk()
            ->assertSee('Open Garden Room')
            ->assertDontSee('Taken Lake Room');
    }

    public function test_admins_can_reply_to_contact_messages(): void
    {
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $contact = Contact::factory()->create();

        $this->actingAs($admin)->post(route('admin.messages.send', $contact), [
            'greeting' => 'Hello '.$contact->name,
            'body' => 'Thanks for getting in touch. We have availability next weekend.',
            'end_line' => 'Kind regards',
        ])->assertRedirect(route('admin.messages.index'));

        $this->assertNotNull($contact->fresh()->replied_at);
    }
}
