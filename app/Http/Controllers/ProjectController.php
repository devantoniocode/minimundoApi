<?php

namespace App\Http\Controllers;

use App\Responses\Responses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Project\ProjectService;
use App\Services\Task\TaskService;

class ProjectController extends Controller
{
    protected $projectService, $taskService;

    public function __construct(ProjectService $projectService, TaskService $taskService)
    {
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    public function data(Request $request)
    {
        $status = array(
            ["value" => "ATIVO", "text" => "Ativo"],
            ["value" => "INATIVO", "text" => "Inativo"],
        );

        return response()->json(compact("status"));
    }


    public function validateRequest(Request $request)
    {
        $request->validate([
            "name" => ["required", Rule::unique("projects")->whereNull("deleted_at")->ignore($request->id)],
        ]);
    }

    public function index(Request $request)
    {
        $projects = $this->projectService->getAll($request);

        $registros = $projects["data"];

        return response()->json(compact("registros"));
    }

    public function store(Request $request)
    {
        self::validateRequest($request);

        $results = $this->projectService->create($request->toArray());

        $registros = $results["data"];

        return response()->json(compact("registros"));
    }
    public function edit(Request $request, $id)
    {
        $result = $this->projectService->getId($id);

        $registro = $result["data"];

        return response()->json(compact("registro"));
    }
    public function update(Request $request, $id)
    {
        self::validateRequest($request);

        $this->projectService->update($id, $request->toArray());

        return response([], 200);
    }
    public function destroy($id)
    {
        $this->projectService->delete($id);

        return response([], 200);
    }

    public function showTasks(Request $request)
    {
        $results =   $this->taskService->getAllProjectById($request->project_id);
        $tasks = $results["data"];

        return response()->json(compact("tasks"));
    }
}
