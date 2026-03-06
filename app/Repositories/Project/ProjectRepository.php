<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Responses\Responses;

class ProjectRepository
{
    public function list()
    {
        return Project::query()
            ->select("id AS value", "name AS text")
            ->orderBy("name")->get();
    }

    public function allProject($request)
    {
        return Project::query()
            ->select("projects.*")
            ->leftJoin("tasks", "tasks.project_id", "=", "projects.id")
            ->selectRaw("COUNT(tasks.id) AS total")
            ->selectRaw("COUNT(IF(tasks.status = 'CONCLUIDA', 1, NULL)) AS finish")
            ->when(isset($request->name), fn($fn) => $fn->where("projects.name", "like", "{$request->name}%"))
            ->when(isset($request->description), fn($fn) => $fn->where("projects.description", "like", "%{$request->description}%"))
            ->when(isset($request->date1), fn($fn) => $fn->where("projects.created_at", ">=", "{$request->date1} 00:00:00"))
            ->when(isset($request->date2), fn($fn) => $fn->where("projects.created_at", "<=", "{$request->date2} 23:59:59"))
            ->when(isset($request->status), fn($fn) => $fn->where("projects.status", "=", $request->status))
            ->groupBy("projects.id")
            ->orderBy("projects.name")
            ->paginate();
    }

    public function find(int $id)
    {
        return Project::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update($id, array $data): Object
    {
        $project = $this->find($id);

        if (!isset($project))
            Responses::alert("Registro não encontrado!");

        $project->update($data);

        return $project;
    }

    public function delete($id)
    {
        $project = $this->find($id);

        if (!isset($project))
            Responses::alert("Registro não encontrado!");

        return $project->delete();
    }
}
