<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Notifications\BookingReceivedNotification;
use App\Notifications\BookingStatusNotification;
use App\Notifications\NewBookingAdminNotification;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Notification;

class BookingService
{
    public function isUnavailable(Room $room, CarbonInterface $startDate, CarbonInterface $endDate, ?Booking $ignore = null): bool
    {
        return Booking::query()
            ->where('room_id', $room->id)
            ->blocking()
            ->when($ignore, fn ($query) => $query->where('id', '!=', $ignore->id))
            ->whereDate('start_date', '<', $endDate->toDateString())
            ->whereDate('end_date', '>', $startDate->toDateString())
            ->exists();
    }

    public function create(Room $room, array $data, User $user): Booking
    {
        $booking = Booking::query()->create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => Booking::STATUS_PENDING,
        ]);

        $booking->setRelation('room', $room);
        $this->notifyGuest($booking, new BookingReceivedNotification($booking));
        $this->notifyAdmins($booking);

        return $booking;
    }

    public function updateStatus(Booking $booking, string $status): Booking
    {
        $booking->update(['status' => $status]);
        $booking->refresh()->loadMissing('room');
        $this->notifyGuest($booking, new BookingStatusNotification($booking));

        return $booking;
    }

    public function cancel(Booking $booking): Booking
    {
        return $this->updateStatus($booking, Booking::STATUS_CANCELLED);
    }

    public function notifyGuest(Booking $booking, BookingReceivedNotification|BookingStatusNotification $notification): void
    {
        $booking->loadMissing('room');

        if ($booking->user) {
            $booking->user->notify($notification);
        } elseif ($booking->email) {
            Notification::route('mail', $booking->email)->notify($notification);
        }
    }

    private function notifyAdmins(Booking $booking): void
    {
        $admins = User::query()->where('usertype', User::TYPE_ADMIN)->get();

        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, new NewBookingAdminNotification($booking));
    }
}
