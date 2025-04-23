<?php
namespace App\Repositories;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryInterface
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        return $query->paginate(10);
    }

    public function find(int $id): ?Event
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Event
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Event
    {
        $event = $this->find($id);
        $event->update($data);
        return $event;
    }

    public function delete(int $id): bool
    {
        $event = $this->find($id);
        return $event->delete();
    }
}