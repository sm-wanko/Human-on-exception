<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\DTO\Task\TaskDetail;
use App\DTO\Task\TaskQuick;
use App\Repositories\Task\TaskRepository;

final readonly class TaskService
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    /** @return list<TaskQuick> */
    public function list(): array
    {
        return $this->tasks->listQuick();
    }

    public function detail(int $id): ?TaskDetail
    {
        return $this->tasks->findDetail($id);
    }

    public function create(string $title, ?string $description): TaskDetail
    {
        return $this->tasks->create($title, $description);
    }

    public function update(int $id, string $title, ?string $description): ?TaskDetail
    {
        return $this->tasks->update($id, $title, $description);
    }

    public function delete(int $id): bool
    {
        return $this->tasks->delete($id);
    }
}
