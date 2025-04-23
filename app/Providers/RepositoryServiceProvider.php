<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\Contracts\AttendeeRepositoryInterface;
use App\Repositories\AttendeeRepository;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\BookingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(AttendeeRepositoryInterface::class, AttendeeRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }
}