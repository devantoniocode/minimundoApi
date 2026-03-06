<?php

namespace App\Http\Controllers;

use App\Responses\Responses;
use Illuminate\Http\Request;
use App\Services\Task\TaskService;
use App\Services\Project\ProjectService;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    protected $taskService, $projectService;

    public function __construct(TaskService $taskService, ProjectService $projectService)
    {
        $this->taskService = $taskService;
        $this->projectService = $projectService;
    }

    public function data(Request $request)
    {
        $resultsTasks = $this->taskService->list();
        $resultsProject = $this->projectService->list();
        $status = array(
            ["value" => "CONCLUIDA", "text" => "Concluída"],
            ["value" => "NAO_CONCLUIDA", "text" => "Não Concluída"],
        );

        $projects = $resultsProject["data"];
        $tasks = $resultsTasks["data"];


        return response()->json(compact("projects", 'status', 'tasks'));
    }


    public function validateRequest(Request $request)
    {
        $request->validate([
            "description" => ["required", Rule::unique("tasks")->whereNull("deleted_at")->ignore($request->id)],
            "project_id" => "required",
            "status" => "required",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|after_or_equal:start_date",
        ]);
    }

    public function index(Request $request)
    {
        $projects = $this->taskService->getAll($request);

        $registros = $projects["data"];

        return response()->json(compact("registros"));
    }

    public function store(Request $request)
    {
        self::validateRequest($request);

        $results = $this->taskService->create($request->toArray());

        $registros = $results["data"];

        return response()->json(compact("registros"));
    }
    public function edit(Request $request, $id)
    {
        $result = $this->taskService->getId($id);

        $registro = $result["data"];

        return response()->json(compact("registro"));
    }
    public function update(Request $request, $id)
    {
        self::validateRequest($request);

        $this->taskService->update($id, $request->toArray());

        return response([], 200);
    }
    public function destroy($id)
    {
        $this->taskService->delete($id);

        return response([], 200);
    }
}
