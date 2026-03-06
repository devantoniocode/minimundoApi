<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'predecessor_task_id' => null,
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['NAO_CONCLUIDA', 'CONCLUIDA', 'EM_ANDAMENTO', 'BLOQUEADA']),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'CONCLUIDA',
            'end_date' => now(),
        ]);
    }

    public function notCompleted(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'NAO_CONCLUIDA',
        ]);
    }

    public function withPredecessor(): static
    {
        return $this->state(fn(array $attributes) => [
            'predecessor_task_id' => Task::factory(),
        ]);
    }
}
