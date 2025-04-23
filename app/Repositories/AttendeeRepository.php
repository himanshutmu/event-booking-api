<?php
namespace App\Repositories;

use App\Repositories\Contracts\AttendeeRepositoryInterface;
use App\Models\Attendee;

class AttendeeRepository implements AttendeeRepositoryInterface
{
    protected $model;

    public function __construct(Attendee $model)
    {
        $this->model = $model;
    }

    public function findByEmail(string $email): ?Attendee
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): Attendee
    {
        return $this->model->create($data);
    }
}