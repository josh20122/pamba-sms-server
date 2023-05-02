<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname'=>$this->faker->name(),
            'lastname'=>$this->faker->name(),
            'phone_number'=>$this->faker->phonenumber(),
            'gender'=>$this->faker->randomElement(['male', 'female']),
            'age'=>$this->faker->numberBetween(18,35),

            'region'=>$this->faker->address,
            'district'=>$this->faker->address,
            'ward'=>$this->faker->address,
            'village'=>$this->faker->address,
            'sub_village'=>$this->faker->address,
            'amcos'=>$this->faker->address,
            'amcos_physical_location'=>$this->faker->address,

            'collector_name'=>$this->faker->name,
            'collector_phone_number'=>$this->faker->phoneNumber(),
            'wheight'=>$this->faker->name,
            'price_per_kg'=>'3000',
            'wheight'=>$this->faker->numberBetween(10,30),
        ];
    }
}
