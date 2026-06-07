<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->firstName(),
            'family'            => fake()->lastName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => bcrypt('password'), // password
            'remember_token'    => Str::random(10),
            'age'               => fake()->numberBetween(18, 60),
            'state'             => fake()->state(),
            'city'              => fake()->city(),
            'address'           => fake()->address(),
            'company_id'        => null,
            'phone_number'      => fake()->phoneNumber(),
            'national_id'       => fake()->numerify('##########'),
            'telegram_phone'    => null,
            'telegram_id'       => null,
            'static_ip'         => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
