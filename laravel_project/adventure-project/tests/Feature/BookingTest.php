<?php

namespace Tests\Feature;

use App\Models\AdventureSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking(): void
    {
        $user = User::factory()->create();
        $schedule = AdventureSchedule::factory()->create();

        $response = $this->actingAs($user)
            ->post('/user/bookings', [
                'schedule_id' => $schedule->id,
                'participants' => 2,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    public function test_user_can_view_own_bookings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/user/bookings');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('User/Bookings/Index'));
    }

    public function test_user_can_cancel_own_booking(): void
    {
        $user = User::factory()->create();
        $schedule = AdventureSchedule::factory()->create();

        $booking = $user->bookings()->create([
            'adventure_id' => $schedule->adventure_id,
            'schedule_id' => $schedule->id,
            'booking_date' => $schedule->trip_date,
            'participants' => 1,
            'total_price' => 100,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)
            ->delete("/user/bookings/{$booking->id}");

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
