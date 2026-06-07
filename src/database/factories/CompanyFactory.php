<?php
namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name'                          => fake()->company(),
            'username'                      => fake()->unique()->userName(),
            'address'                       => fake()->address(),
            'state'                         => fake()->state(),
            'city'                          => fake()->city(),
            'phone'                         => fake()->phoneNumber(),
            'name_boss'                     => fake()->name(),
            'phone_boss'                    => fake()->phoneNumber(),
            'phone_representative'          => fake()->phoneNumber(),
            'capacity'                      => fake()->numberBetween(10, 200),
            'sm_tel'                        => fake()->phoneNumber(),
            'sm_instagram'                  => null,
            'sm_telegram'                   => null,
            'sm_whatsapp'                   => null,
            'sm_twitter'                    => null,
            'sm_threads'                    => null,
            'sm_website'                    => fake()->url(),
            'zip'                           => fake()->postcode(),
            'lat'                           => fake()->latitude(),
            'long'                          => fake()->longitude(),
            'plan_menu'                     => false,
            'plan_order_taker'              => false,
            'plan_time_report'              => false,
            'plan_online_order'             => false,
            'plan_printer_control'          => false,
            'plan_preparation_notification' => false,
            'active'                        => false,
            'fee_received'                  => fake()->numberBetween(50000, 500000),
            'image'                         => null,
        ];
    }
}
