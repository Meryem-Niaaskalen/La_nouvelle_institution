<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'icon' => '📚',
            'order' => 0,
            'is_active' => true,
        ];
    }
}
