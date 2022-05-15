<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'ip' => $this->faker->ipv4(),
            'user_id' => User::factory(),
            'user' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'ikev2' => $this->faker->boolean(),
        ];
    }
}
