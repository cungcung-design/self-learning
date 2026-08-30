<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\FeaturedCategory;
use App\Models\Gallery;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\Room;
use App\Models\User;
use App\Support\RoomFeatureGallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
                'password' => 'password',
            ]
        );

        $guest = User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Guest User',
                'phone' => '0111111111',
                'usertype' => User::TYPE_USER,
                'password' => 'password',
            ]
        );

        $featuredCategories = [
            ['name' => 'Best Seller', 'slug' => 'best-seller'],
            ['name' => 'Popular', 'slug' => 'popular'],
            ['name' => 'Luxury', 'slug' => 'luxury'],
        ];

        foreach ($featuredCategories as $category) {
            FeaturedCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $amenities = [
            ['name' => 'King Bed', 'slug' => 'king-bed', 'icon' => 'fa fa-bed'],
            ['name' => 'Free Wi-Fi', 'slug' => 'free-wi-fi', 'icon' => 'fa fa-wifi'],
            ['name' => 'Swimming Pool', 'slug' => 'swimming-pool', 'icon' => 'fa fa-tint'],
            ['name' => 'Breakfast Included', 'slug' => 'breakfast-included', 'icon' => 'fa fa-coffee'],
            ['name' => 'Air Conditioning', 'slug' => 'air-conditioning', 'icon' => 'fa fa-snowflake-o'],
            ['name' => 'Free Parking', 'slug' => 'free-parking', 'icon' => 'fa fa-car'],
            ['name' => 'Restaurant', 'slug' => 'restaurant', 'icon' => 'fa fa-cutlery'],
            ['name' => 'Gym', 'slug' => 'gym', 'icon' => 'fa fa-futbol-o'],
            ['name' => 'Spa', 'slug' => 'spa', 'icon' => 'fa fa-leaf'],
            ['name' => 'Airport Shuttle', 'slug' => 'airport-shuttle', 'icon' => 'fa fa-plane'],
            ['name' => '24/7 Front Desk', 'slug' => 'front-desk', 'icon' => 'fa fa-clock-o'],
            ['name' => 'TV', 'slug' => 'tv', 'icon' => 'fa fa-television'],
            ['name' => 'Minibar', 'slug' => 'minibar', 'icon' => 'fa fa-glass'],
            ['name' => 'Bathtub', 'slug' => 'bathtub', 'icon' => 'fa fa-bath'],
            ['name' => 'Balcony', 'slug' => 'balcony', 'icon' => 'fa fa-cloud'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::query()->updateOrCreate(
                ['slug' => $amenity['slug']],
                $amenity
            );
        }

        $hotelImages = [
            'images/hotels/oceanview-1.jpg',
            'images/hotels/oceanview-2.jpg',
            'images/hotels/royal-1.jpg',
            'images/hotels/royal-2.jpg',
            'images/hotels/grandbay-1.jpg',
            'images/hotels/sunset-1.jpg',
            'images/hotels/harbour-1.jpg',
            'images/hotels/palmgrove-1.jpg',
            'images/hotels/citylight-1.jpg',
            'images/hotels/heritage-1.jpg',
            'images/hotels/keto-1.jpg',
            'images/hotels/serenity-1.jpg',
        ];

        $hotelsData = [
            [
                'name' => 'Oceanview Grand Resort',
                'slug' => 'oceanview-grand-resort',
                'description' => 'A breathtaking beachfront resort offering panoramic ocean views, premium amenities, and world-class service. Perfect for romantic getaways and family vacations.',
                'price' => 399.00,
                'location' => 'Langkawi',
                'contact_info' => '+60 4 123 4567 | info@oceanviewgrand.test',
                'check_in_time' => '15:00',
                'check_out_time' => '11:00',
                'rating' => 4.9,
                'status' => 'active',
                'categories' => ['luxury', 'best-seller'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'spa', 'free-parking', 'airport-shuttle', '24/7-front-desk'],
                'room_types' => [
                    [
                        'name' => 'Deluxe Ocean View Room',
                        'description' => 'Spacious room with a private balcony overlooking the Andaman Sea. Features a king-size bed and premium amenities.',
                        'price' => 399.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '42 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'balcony'],
                    ],
                    [
                        'name' => 'Executive Suite',
                        'description' => 'A generous suite with separate living area, workspace, and panoramic ocean views. Ideal for business travelers.',
                        'price' => 599.00,
                        'max_guests' => 4,
                        'beds' => 2,
                        'bed_type' => 'King + Twin',
                        'room_size' => '65 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub', 'balcony'],
                    ],
                    [
                        'name' => 'Family Room',
                        'description' => 'Comfortable family room with two double beds and a cozy seating area. Perfect for families with children.',
                        'price' => 459.00,
                        'max_guests' => 5,
                        'beds' => 2,
                        'bed_type' => 'Double + Double',
                        'room_size' => '55 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'balcony'],
                    ],
                ],
            ],
            [
                'name' => 'Royal Palace Hotel',
                'slug' => 'royal-palace-hotel',
                'description' => 'Experience regal luxury in the heart of Kuala Lumpur. This iconic hotel combines traditional Malay architecture with modern sophistication.',
                'price' => 349.00,
                'location' => 'Kuala Lumpur',
                'contact_info' => '+60 3 234 5678 | concierge@royalpalace.test',
                'check_in_time' => '14:30',
                'check_out_time' => '12:00',
                'rating' => 4.8,
                'status' => 'active',
                'categories' => ['luxury', 'popular'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'spa', 'gym', 'free-parking', 'airport-shuttle', '24/7-front-desk'],
                'room_types' => [
                    [
                        'name' => 'Premium Deluxe Room',
                        'description' => 'Elegant room with city skyline views, featuring a king-size bed and a marble bathroom with a soaking tub.',
                        'price' => 349.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '38 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub'],
                    ],
                    [
                        'name' => 'Twin Executive Room',
                        'description' => 'Perfect for colleagues or friends, this room offers two twin beds with premium bedding and a work desk.',
                        'price' => 299.00,
                        'max_guests' => 2,
                        'beds' => 2,
                        'bed_type' => 'Twin',
                        'room_size' => '32 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                    [
                        'name' => 'Royal Suite',
                        'description' => 'The pinnacle of luxury. A sprawling suite with a dining area, butler service, and unmatched city views.',
                        'price' => 899.00,
                        'max_guests' => 6,
                        'beds' => 3,
                        'bed_type' => 'King + King + Twin',
                        'room_size' => '95 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub', 'balcony'],
                    ],
                ],
            ],
            [
                'name' => 'Grand Bay Resort',
                'slug' => 'grand-bay-resort',
                'description' => 'Nestled along the pristine coastline of Penang, Grand Bay Resort offers tranquil surroundings and easy access to local attractions.',
                'price' => 279.00,
                'location' => 'Penang',
                'contact_info' => '+60 4 567 8901 | stay@grandbay.test',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'rating' => 4.7,
                'status' => 'active',
                'categories' => ['best-seller'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'free-parking', 'breakfast-included'],
                'room_types' => [
                    [
                        'name' => 'Bay View Room',
                        'description' => 'Bright and airy room with views of the bay. Includes a queen bed and a small workspace.',
                        'price' => 279.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'Queen',
                        'room_size' => '28 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                    [
                        'name' => 'Garden Deluxe',
                        'description' => 'Ground-floor room opening to a lush tropical garden. Features a king bed and rain shower.',
                        'price' => 329.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '35 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub'],
                    ],
                ],
            ],
            [
                'name' => 'Sunset Beach Hotel',
                'slug' => 'sunset-beach-hotel',
                'description' => 'A relaxed beachside escape with golden sunsets, casual dining, and comfortable rooms just steps from the shore.',
                'price' => 189.00,
                'location' => 'Langkawi',
                'contact_info' => '+60 4 789 0123 | hello@sunsetbeach.test',
                'check_in_time' => '13:00',
                'check_out_time' => '11:00',
                'rating' => 4.4,
                'status' => 'inactive',
                'categories' => ['popular'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'free-parking', 'free-wi-fi'],
                'room_types' => [
                    [
                        'name' => 'Standard King Room',
                        'description' => 'Cozy room with a king bed and basic amenities. Great for solo travelers or couples on a budget.',
                        'price' => 189.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '22 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning'],
                    ],
                    [
                        'name' => 'Beachfront Twin Room',
                        'description' => 'Two twin beds with direct beach views. Includes a small balcony for morning coffee.',
                        'price' => 219.00,
                        'max_guests' => 2,
                        'beds' => 2,
                        'bed_type' => 'Twin',
                        'room_size' => '26 sqm',
                        'is_available' => false,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'balcony'],
                    ],
                ],
            ],
            [
                'name' => 'Harbour View Hotel',
                'slug' => 'harbour-view-hotel',
                'description' => 'Modern business hotel with stunning harbour views, meeting facilities, and quick access to the city center.',
                'price' => 259.00,
                'location' => 'Kuala Lumpur',
                'contact_info' => '+60 3 890 1234 | bookings@harbourview.test',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'rating' => 4.6,
                'status' => 'active',
                'categories' => ['popular', 'best-seller'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'gym', 'free-parking', 'airport-shuttle', '24/7-front-desk'],
                'room_types' => [
                    [
                        'name' => 'Harbour Deluxe',
                        'description' => 'Sleek room with harbour-facing windows, a king bed, and a smart TV with streaming apps.',
                        'price' => 259.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '30 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar'],
                    ],
                    [
                        'name' => 'Business Twin Room',
                        'description' => 'Practical room with two twin beds, a large desk, and ergonomic chair for working travelers.',
                        'price' => 239.00,
                        'max_guests' => 2,
                        'beds' => 2,
                        'bed_type' => 'Twin',
                        'room_size' => '28 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                    [
                        'name' => 'Executive Studio',
                        'description' => 'Open-plan studio with a king bed, kitchenette, and lounge area. Perfect for extended stays.',
                        'price' => 349.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '40 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'balcony'],
                    ],
                ],
            ],
            [
                'name' => 'Palm Grove Resort',
                'slug' => 'palm-grove-resort',
                'description' => 'A tropical retreat surrounded by palm trees and manicured gardens. Features a large lagoon-style pool and water sports.',
                'price' => 319.00,
                'location' => 'Penang',
                'contact_info' => '+60 4 321 6549 | relax@palmgrove.test',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'rating' => 4.5,
                'status' => 'active',
                'categories' => ['luxury'],
                'amenity_slugs' => ['swimming-pool', 'restaurant', 'spa', 'gym', 'free-parking', 'breakfast-included'],
                'room_types' => [
                    [
                        'name' => 'Garden Villa',
                        'description' => 'Private villa with a plunge pool, outdoor shower, and direct garden access.',
                        'price' => 599.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '60 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub', 'balcony'],
                    ],
                    [
                        'name' => 'Pool Access Room',
                        'description' => 'Ground-floor room with direct pool access and a sun deck.',
                        'price' => 399.00,
                        'max_guests' => 3,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '38 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar'],
                    ],
                ],
            ],
            [
                'name' => 'Citylight Hotel',
                'slug' => 'citylight-hotel',
                'description' => 'A stylish urban hotel with rooftop dining, vibrant nightlife nearby, and compact modern rooms for city explorers.',
                'price' => 169.00,
                'location' => 'Kuala Lumpur',
                'contact_info' => '+60 3 456 7890 | stay@citylight.test',
                'check_in_time' => '15:00',
                'check_out_time' => '11:00',
                'rating' => 4.2,
                'status' => 'active',
                'categories' => ['popular'],
                'amenity_slugs' => ['restaurant', 'gym', 'free-parking', 'free-wi-fi', '24/7-front-desk'],
                'room_types' => [
                    [
                        'name' => 'Compact King Room',
                        'description' => 'Efficiently designed room with a king bed, smart TV, and a compact work area.',
                        'price' => 169.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '20 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                    [
                        'name' => 'Twin Budget Room',
                        'description' => 'Affordable twin room with shared bathroom access and basic amenities.',
                        'price' => 139.00,
                        'max_guests' => 2,
                        'beds' => 2,
                        'bed_type' => 'Twin',
                        'room_size' => '18 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi'],
                    ],
                ],
            ],
            [
                'name' => 'Serenity Wellness Resort',
                'slug' => 'serenity-wellness-resort',
                'description' => 'A holistic wellness retreat offering yoga, spa treatments, healthy dining, and serene nature trails.',
                'price' => 449.00,
                'location' => 'Langkawi',
                'contact_info' => '+60 4 654 3210 | wellness@serenity.test',
                'check_in_time' => '14:00',
                'check_out_time' => '11:00',
                'rating' => 4.8,
                'status' => 'active',
                'categories' => ['luxury', 'best-seller'],
                'amenity_slugs' => ['spa', 'swimming-pool', 'restaurant', 'gym', 'free-parking', 'breakfast-included', 'airport-shuttle'],
                'room_types' => [
                    [
                        'name' => 'Wellness Suite',
                        'description' => 'Suite with a private yoga deck, aromatherapy diffuser, king bed, and rain shower.',
                        'price' => 449.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '45 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub', 'balcony'],
                    ],
                    [
                        'name' => 'Detox Double Room',
                        'description' => 'Calm room with herbal tea amenities, a queen bed, and a meditation corner.',
                        'price' => 379.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'Queen',
                        'room_size' => '32 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                ],
            ],
            [
                'name' => 'Heritage Inn',
                'slug' => 'heritage-inn',
                'description' => 'A charming boutique hotel in a restored colonial building. Features wooden floors, high ceilings, and vintage decor.',
                'price' => 199.00,
                'location' => 'Penang',
                'contact_info' => '+60 4 987 6543 | stay@heritageinn.test',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'rating' => 4.5,
                'status' => 'active',
                'categories' => ['best-seller', 'popular'],
                'amenity_slugs' => ['restaurant', 'free-wi-fi', '24/7-front-desk', 'breakfast-included'],
                'room_types' => [
                    [
                        'name' => 'Heritage Double Room',
                        'description' => 'Cozy room with a queen bed, vintage furniture, and a small reading nook.',
                        'price' => 199.00,
                        'max_guests' => 2,
                        'beds' => 1,
                        'bed_type' => 'Queen',
                        'room_size' => '24 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv'],
                    ],
                    [
                        'name' => 'Colonial Suite',
                        'description' => 'Spacious suite with a four-poster bed, antique writing desk, and ensuite bathroom.',
                        'price' => 299.00,
                        'max_guests' => 3,
                        'beds' => 1,
                        'bed_type' => 'King',
                        'room_size' => '40 sqm',
                        'is_available' => true,
                        'amenity_slugs' => ['king-bed', 'free-wi-fi', 'air-conditioning', 'tv', 'minibar', 'bathtub'],
                    ],
                ],
            ],
        ];

        foreach ($hotelsData as $hotelData) {
            $categories = $hotelData['categories'];
            unset($hotelData['categories']);

            $amenitySlugs = $hotelData['amenity_slugs'];
            unset($hotelData['amenity_slugs']);

            $roomTypes = $hotelData['room_types'];
            unset($hotelData['room_types']);

            $hotel = Hotel::query()->updateOrCreate(
                ['slug' => $hotelData['slug']],
                $hotelData
            );

            $hotel->featuredCategories()->sync(
                FeaturedCategory::query()->whereIn('slug', $categories)->pluck('id')->toArray()
            );

            $hotel->amenities()->sync(
                Amenity::query()->whereIn('slug', $amenitySlugs)->pluck('id')->toArray()
            );

            if ($hotel->hotelImages()->count() === 0) {
                $primaryHotelImage = $hotelImages[array_rand($hotelImages)];
                $hotel->hotelImages()->create([
                    'image_url' => $primaryHotelImage,
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
                $hotel->update(['image' => $primaryHotelImage]);

                $extraHotelImages = array_diff($hotelImages, [$primaryHotelImage]);
                shuffle($extraHotelImages);
                $sortOrder = 2;
                foreach (array_slice($extraHotelImages, 0, 4) as $imagePath) {
                    $hotel->hotelImages()->create([
                        'image_url' => $imagePath,
                        'is_primary' => false,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            foreach ($roomTypes as $roomData) {
                $roomAmenitySlugs = $roomData['amenity_slugs'];
                unset($roomData['amenity_slugs']);

                $roomData['room_name'] = $roomData['name'];
                unset($roomData['name']);

                $roomData['room_description'] = $roomData['description'] ?? null;
                unset($roomData['description']);

                $roomData['room_price'] = $roomData['price'] ?? null;
                unset($roomData['price']);

                $roomData['room_wifi'] = in_array('free-wi-fi', $roomAmenitySlugs) ? 'yes' : 'no';

                $room = $hotel->rooms()->updateOrCreate(
                    ['hotel_id' => $hotel->id, 'room_name' => $roomData['room_name']],
                    $roomData
                );

                $room->roomAmenities()->sync(
                    Amenity::query()->whereIn('slug', $roomAmenitySlugs)->pluck('id')->toArray()
                );

                if ($room->roomImages()->count() === 0) {
                    $room->load('roomAmenities');
                    RoomFeatureGallery::sync($room);
                }
            }
        }

        if (Booking::query()->count() === 0) {
            $allRooms = Room::query()->get();
            if ($allRooms->isNotEmpty()) {
                Booking::factory()->create([
                    'user_id' => $guest->id,
                    'room_id' => $allRooms->first()->id,
                    'name' => $guest->name,
                    'email' => $guest->email,
                    'phone' => $guest->phone,
                    'start_date' => now()->addDays(5)->toDateString(),
                    'end_date' => now()->addDays(8)->toDateString(),
                    'status' => Booking::STATUS_PENDING,
                ]);

                Booking::factory()->create([
                    'user_id' => $guest->id,
                    'room_id' => $allRooms->last()->id,
                    'name' => $guest->name,
                    'email' => $guest->email,
                    'phone' => $guest->phone,
                    'start_date' => now()->addDays(12)->toDateString(),
                    'end_date' => now()->addDays(14)->toDateString(),
                    'status' => Booking::STATUS_APPROVED,
                ]);
            }
        }

        if (Contact::query()->count() === 0) {
            Contact::factory()->create([
                'name' => 'Maria Tan',
                'email' => 'maria@example.com',
                'phone' => '0122223333',
                'message' => 'Do you offer airport transfer for late-night arrivals?',
            ]);
        }

        if (Gallery::query()->count() === 0) {
            foreach (['images/blog1.jpg', 'images/blog2.jpg', 'images/blog3.jpg', 'images/about.png'] as $image) {
                Gallery::query()->create(['image' => $image]);
            }
        }
    }
}
