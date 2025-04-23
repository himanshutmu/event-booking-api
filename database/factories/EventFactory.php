<?php
namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{

    protected $model = Event::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->unique()->country(),
            'capacity' => $this->faker->numberBetween(1, 100),
            'start_time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_time' => $this->faker->dateTimeBetween('+1 day', '+1 year')
        ];
    }
}
