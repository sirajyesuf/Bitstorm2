<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class AlertFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id,
            'user_id'    => User::all()->random()->id 
        ];
    }
}
