<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepository;
use App\Responses\Responses;
use Symfony\Component\HttpFoundation\Response;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function list()
    {
        $results = $this->taskRepository->list();

        return ['data' => $results];
    }

    public function show($request)
    {
        return $this->taskRepository->allTask($request);
    }

    public function create(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }

    public function delete($id)
    {
        $predecessorTask = $this->taskRepository->getPredecessorTaskId($id);

        if (isset($predecessorTask))
            Responses::alert("A task precede outra task. Exclusão não permitida!");

        return $this->taskRepository->delete($id);
    }

    public function complete($id)
    {
        $task = $this->taskRepository->find($id);

        $completed = !$task->completed;

        return $this->taskRepository->update($id, ['completed' => $completed]);
    }

    public function getAllProjectById($projectId)
    {
        $results = $this->taskRepository->getAllProjectById($projectId);

        foreach ($results as $result) {
            $result->class_status = $result->status == "NAO_CONCLUIDA" ? "info" : "success";
            $result->status_br = $result->status == "NAO_CONCLUIDA" ? "NÃO CONCLUÍDA" : ($result->status == "CONCLUIDA" ? "Concluída" : $result->status);
        }

        return ['data' => $results];
    }

    public function getId($id)
    {
        $result = $this->taskRepository->find($id);


        return ['data' => $result];
    }


    public function getAll($request)
    {
        $results = $this->taskRepository->allTask($request);

        foreach ($results as $result) {
            $result->class_status = $result->status == "NAO_CONCLUIDA" ? "info" : "success";
            $result->status_br = $result->status == "NAO_CONCLUIDA" ? "NÃO CONCLUÍDA" : ($result->status == "CONCLUIDA" ? "Concluída" : $result->status);
        }

        return ['data' => $results];
    }
}
