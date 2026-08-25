<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Contact;
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
    }
}
