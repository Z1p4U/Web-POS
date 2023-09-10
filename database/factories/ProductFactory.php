<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = rand(400,1500);
        return [
            "name" => fake()->word(),
            "brand_id" => rand(1,5),
            "user_id" => 1,
            "actual_price" => $price,
            "sale_price" => $price + 1000,
            "total_stock" => 0,
            "unit" => "piece",
        ];
    }
}
