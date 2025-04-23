<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Attendee;

class AttendeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_attendee()
    {
        $response = $this->postJson('/api/attendees', [
            'email' => 'Kt9oQ@example.com',
            'name' => 'John Doe',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'email', 'name']);
    }

    public function test_prevents_duplicate_attendee()
    {
        Attendee::factory()->create(['email' => 'Kt9oQ@example.com']);

        $response = $this->postJson('/api/attendees', [
            'email' => 'Kt9oQ@example.com',
            'name' => 'John Doe',
        ]);

        $response->assertStatus(422);
    }
}
