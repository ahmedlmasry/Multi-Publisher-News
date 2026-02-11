<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->date('Y-m-d H:i:s');
        return [
            'title' => fake()->sentence(3),
            'desc' => fake()->paragraph(5),
            'status' => rand(0, 1),
            'comment_able' => rand(0, 1),
            'num_of_views' => rand(0, 100),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
