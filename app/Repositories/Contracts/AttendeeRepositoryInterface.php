<?php
namespace App\Repositories\Contracts;

use App\Models\Attendee;

interface AttendeeRepositoryInterface
{
    public function findByEmail(string $email): ?Attendee;
    public function create(array $data): Attendee;
}