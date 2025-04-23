<?php
namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Event;

interface EventRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;
    public function find(int $id): ?Event;
    public function create(array $data): Event;
    public function update(int $id, array $data): Event;
    public function delete(int $id): bool;
}