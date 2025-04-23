<?php
namespace App\Repositories;

use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Models\Booking;

class BookingRepository implements BookingRepositoryInterface
{
    protected $model;

    public function __construct(Booking $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Booking
    {
        return $this->model->create($data);
    }

    public function exists(int $eventId, int $attendeeId): bool
    {
        return $this->model->where('event_id', $eventId)
            ->where('attendee_id', $attendeeId)
            ->exists();
    }

    public function countByEvent(int $eventId): int
    {
        return $this->model->where('event_id', $eventId)->count();
    }
}