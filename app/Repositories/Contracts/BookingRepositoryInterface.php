<?php
namespace App\Repositories\Contracts;

use App\Models\Booking;

interface BookingRepositoryInterface
{
    public function create(array $data): Booking;
    public function exists(int $eventId, int $attendeeId): bool;
    public function countByEvent(int $eventId): int;
}