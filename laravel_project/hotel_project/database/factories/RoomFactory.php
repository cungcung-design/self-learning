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
            'room_name' => fake()->words(3, true),
            'room_description' => fake()->paragraph(),
            'room_price' => fake()->randomFloat(2, 80, 450),
            'room_wifi' => fake()->randomElement(['yes', 'no']),
            'room_type' => fake()->randomElement(Room::TYPES),
            'room_image' => null,
        ];
    }
}
