<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->words(2, true);
        $parent = Category::inRandomOrder()->first();
        $status = ['active', 'inactive'];
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => $parent->id,
            'description' => fake()->words(50, true),
            'image_path' => fake()->imageUrl(),
            'status' => $status[array_rand($status)]
        ];
    }
}
