<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ms_MY')->name(),
            'ic' => fake()->unique()->numerify('############'),
            'email' => fake()->unique()->safeEmail(),
            'matric_card' => 'M'.fake()->unique()->numerify('######'),
            'phone' => fake('ms_MY')->phoneNumber(),
        ];
    }

    public function verified(): static
    {
        return $this->state(fn () => [
            'payment_receipt' => 'receipts/sample-receipt.pdf',
            'paid_at' => now()->subDays(fake()->numberBetween(1, 14)),
            'verified_at' => now()->subDays(fake()->numberBetween(0, 7)),
        ]);
    }

    public function paidUnverified(): static
    {
        return $this->state(fn () => [
            'payment_receipt' => 'receipts/sample-receipt.pdf',
            'paid_at' => now()->subDays(fake()->numberBetween(1, 3)),
            'verified_at' => null,
        ]);
    }
}
