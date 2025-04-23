<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event()
    {
        $response = $this->postJson('/api/events', [
            'title' => 'Test Event',
            'description' => 'Test Description',
            'start_time' => now()->addDay()->toDateTimeString(),
            'end_time' => now()->addDay()->addHour()->toDateTimeString(),
            'capacity' => 100,
            'country' => 'USA',
            'state' => 'CA',
            'location' => 'San Francisco',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'start_time', 'end_time', 'capacity', 'country']);
    }

    public function test_can_list_events_with_pagination()
    {
        Event::factory()->count(15)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200);
    }
}