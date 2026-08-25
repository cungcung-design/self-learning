<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Hotel Admin',
                'phone' => '0100000000',
                'usertype' => User::TYPE_ADMIN,
                'password' => Hash::make('password'),
            ]
        );

        $guest = User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Guest User',
                'phone' => '0111111111',
                'usertype' => User::TYPE_USER,
                'password' => Hash::make('password'),
            ]
        );

        if (Room::query()->count() === 0) {
            $rooms = collect([
                Room::factory()->create([
                    'room_name' => 'Deluxe King Room',
                    'room_description' => 'A spacious deluxe room with a king-size bed, city view, and complimentary breakfast.',
                    'room_price' => 189.00,
                    'room_wifi' => 'yes',
                    'room_type' => 'deluxe',
                ]),
                Room::factory()->create([
                    'room_name' => 'Premium Twin Room',
                    'room_description' => 'Comfortable premium room with two twin beds, ideal for friends or colleagues travelling together.',
                    'room_price' => 149.00,
                    'room_wifi' => 'yes',
                    'room_type' => 'premium',
                ]),
                Room::factory()->create([
                    'room_name' => 'Regular Queen Room',
                    'room_description' => 'A well-appointed regular room with a queen bed and all essential amenities for a restful stay.',
                    'room_price' => 99.00,
                    'room_wifi' => 'no',
                    'room_type' => 'regular',
                ]),
                Room::factory()->create([
                    'room_name' => 'Executive Suite',
                    'room_description' => 'A generous suite with a separate living area, workspace, and panoramic views of the city.',
                    'room_price' => 279.00,
                    'room_wifi' => 'yes',
                    'room_type' => 'suite',
                ]),
            ]);
        } else {
            $rooms = Room::query()->get();
        }

        if (Booking::query()->count() === 0 && $rooms->isNotEmpty()) {
            Booking::factory()->create([
                'user_id' => $guest->id,
                'room_id' => $rooms->first()->id,
                'name' => $guest->name,
                'email' => $guest->email,
                'phone' => $guest->phone,
                'start_date' => now()->addDays(5)->toDateString(),
                'end_date' => now()->addDays(8)->toDateString(),
                'status' => Booking::STATUS_PENDING,
            ]);

            Booking::factory()->create([
                'user_id' => $guest->id,
                'room_id' => $rooms->last()->id,
                'name' => $guest->name,
                'email' => $guest->email,
                'phone' => $guest->phone,
                'start_date' => now()->addDays(12)->toDateString(),
                'end_date' => now()->addDays(14)->toDateString(),
                'status' => Booking::STATUS_APPROVED,
            ]);
        }

        if (Contact::query()->count() === 0) {
            Contact::factory()->create([
                'name' => 'Maria Tan',
                'email' => 'maria@example.com',
                'phone' => '0122223333',
                'message' => 'Do you offer airport transfer for late-night arrivals?',
            ]);
        }
    }
}
