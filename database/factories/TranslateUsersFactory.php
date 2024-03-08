<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TranslateUsers>
 */
class TranslateUsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "item_code"=>fake()->randomNumber(),
            "arabic_translation" => fake() -> sentence(),
            "english_translation" => fake() -> sentence(),
            "username" =>fake()->userName()
            
        ];
    }
}
