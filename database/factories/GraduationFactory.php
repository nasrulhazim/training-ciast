<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Graduation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Graduation>
 */
class GraduationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->numberBetween(2024, 2027);
        $month = fake()->randomElement(['March', 'June', 'September', 'December']);

        return [
            'title' => "{$month} {$year} Convocation",
            'ceremony_date' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'fee' => fake()->randomElement([150.00, 200.00, 250.00, 300.00]),
            'status' => fake()->randomElement(['draft', 'open', 'closed']),
        ];
    }

    public function open(): static
    {
        return $this->state(fn () => ['status' => 'open']);
    }

    public function closed(): static
    {
        return $this->state(fn () => ['status' => 'closed']);
    }
}
