<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => null,
            'room_name' => fake()->words(3, true),
            'room_description' => fake()->paragraph(),
            'room_price' => fake()->randomFloat(2, 80, 450),
            'room_wifi' => fake()->randomElement(['yes', 'no']),
            'room_type' => fake()->randomElement(Room::TYPES),
            'room_image' => null,
            'max_guests' => fake()->numberBetween(1, 4),
            'beds' => fake()->numberBetween(1, 3),
            'bed_type' => fake()->randomElement(['King', 'Queen', 'Twin', 'Double']),
            'room_size' => fake()->randomElement(['20 sqm', '25 sqm', '30 sqm', '35 sqm', '50 sqm']),
            'is_available' => fake()->boolean(90),
        ];
    }
}
