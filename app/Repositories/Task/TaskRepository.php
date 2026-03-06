<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Responses\Responses;

class TaskRepository
{
    public function list()
    {
        return Task::query()
            ->select("id AS value", "description AS text")
            ->orderBy("description")->get();
    }


    public function allTask($request)
    {
        $query = Task::query()
            ->select("tasks.*")
            ->with(['project' => fn($query) => $query->select('id', 'name')])
            ->when(isset($request->project_id), fn($fn) => $fn->where("project_id", "=", $request->project_id))
            ->when(isset($request->predecessor_task_id), fn($fn) => $fn->where("predecessor_task_id", "=", $request->predecessor_task_id))
            ->when(isset($request->description), fn($fn) => $fn->where("description", "like", "%{$request->description}%"))
            ->when(isset($request->start_date1), fn($fn) => $fn->where("start_date", ">=", "{$request->start_date1} 00:00:00"))
            ->when(isset($request->start_date2), fn($fn) => $fn->where("start_date", "<=", "{$request->start_date2} 23:59:59"))
            ->when(isset($request->end_date1), fn($fn) => $fn->where("end_date", ">=", "{$request->end_date1} 00:00:00"))
            ->when(isset($request->end_date2), fn($fn) => $fn->where("end_date", "<=", "{$request->end_date2} 23:59:59"))
            ->when(isset($request->status), fn($fn) => $fn->where("status", "=", $request->status))
            ->orderBy("description");

        $results = $request->export_excel ?  $query->get() :  $query->paginate();

        return $results;
    }

    public function allForProject($projectId)
    {
        return Task::query()->where('project_id', $projectId)->orderBy("description")->get();
    }

    public function find($id)
    {
        return Task::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::query()->create($data);
    }

    public function update($id, array $data)
    {
        $task = $this->find($id);

        if (!isset($task))
            Responses::alert("Registro não encontrado!");

        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        $task = $this->find($id);

        if (!isset($task))
            Responses::alert("Registro não encontrado!");

        return $task->delete();
    }

    public function getPredecessorTaskId($predecessorTaskId)
    {
        return Task::query()->where('predecessor_task_id', $predecessorTaskId)->first();
    }

    public function getAllProjectById($projectId)
    {
        return Task::query()
            ->where('project_id', $projectId)
            ->orderBy("description")
            ->paginate(5);
    }
    public function getProjectById($projectId)
    {
        return Task::query()
            ->where('project_id', $projectId)->first();
    }
}
