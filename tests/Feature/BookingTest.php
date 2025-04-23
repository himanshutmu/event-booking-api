<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Attendee;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_book_event()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'email' => $attendee->email,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'event_id', 'attendee_id']);
    }

    public function test_prevents_duplicate_booking()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();
        $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'email' => $attendee->email,
        ]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'email' => $attendee->email,
        ]);

        $response->assertStatus(422)
            ->assertJson(['error' => 'Duplicate booking']);
    }
}