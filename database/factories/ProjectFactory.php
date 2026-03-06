<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['ATIVO', 'INATIVO', 'CONCLUIDO', 'EM_ANDAMENTO']),
            'available_budget' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'ATIVO',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'INATIVO',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'CONCLUIDO',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'EM_ANDAMENTO',
        ]);
    }

    public function highBudget(): static
    {
        return $this->state(fn(array $attributes) => [
            'available_budget' => $this->faker->randomFloat(2, 50000, 500000),
        ]);
    }

    public function lowBudget(): static
    {
        return $this->state(fn(array $attributes) => [
            'available_budget' => $this->faker->randomFloat(2, 100, 10000),
        ]);
    }

    public function withName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
        ]);
    }
}
