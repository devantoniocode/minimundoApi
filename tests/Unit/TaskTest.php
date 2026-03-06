<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_task()
    {
        $project = Project::factory()->create();

        $taskData = [
            'project_id' => $project->id,
            'description' => 'Descrição da minha tarefa',
            'status' => 'NAO_CONCLUIDA'
        ];

        $task = Task::create($taskData);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'project_id' => $project->id,
            'description' => 'Descrição da minha tarefa',
            'status' => 'NAO_CONCLUIDA'
        ]);
    }

    public function test_it_can_update_a_task()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'description' => 'Descrição original',
            'status' => 'NAO_CONCLUIDA'
        ]);

        $task->update(['description' => 'Descrição Atualizada']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'description' => 'Descrição Atualizada'
        ]);
    }

    public function test_it_can_mark_task_as_completed()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'status' => 'NAO_CONCLUIDA'
        ]);

        $task->update(['status' => 'CONCLUIDA']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'CONCLUIDA'
        ]);
    }

    public function test_it_can_delete_a_task()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $task->delete();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
}
