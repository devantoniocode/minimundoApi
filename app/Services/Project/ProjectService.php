<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepository;
use App\Repositories\Task\TaskRepository;
use App\Responses\Responses;

class ProjectService
{
    protected $projectRepository, $taskRepository;

    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }

    public function list()
    {
        $results = $this->projectRepository->list();

        return ['data' => $results];
    }

    public function show($id)
    {
        return $this->projectRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->projectRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->projectRepository->update($id, $data);
    }

    public function delete($id)
    {
        $task = $this->taskRepository->getProjectById($id);

        if (isset($task))
            Responses::alert("Projeto associado a uma tarefa. Exlcusão não permitida!");


        return $this->projectRepository->delete($id);
    }

    public function getId($id)
    {
        $result = $this->projectRepository->find($id);


        return ['data' => $result];
    }

    public function getAll($request)
    {
        $results = $this->projectRepository->allProject($request);

        foreach ($results as $result) {
            $result->class_status = $result->status == "ATIVO" ? "info" : "danger";
            $result->date_br = date("d/m/Y H:i", strtotime($result->created_at));
            $result->progress = $result->total == 0 ? 0 : ($result->finish / $result->total) * 100;
            $result->progress  = round($result->progress, 2) . "%";
        }

        return ['data' => $results];
    }
}
