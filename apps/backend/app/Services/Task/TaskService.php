<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\DTO\Task\TaskDetail;
use App\DTO\Task\TaskQuick;
use App\Repositories\Task\TaskRepository;
use App\Support\Audit\AuditActor;

/** 本人の Task の状態と論理削除 */
final readonly class TaskService
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    /** @return list<TaskQuick> */
    public function list(int $userId): array
    {
        return $this->tasks->listQuick($userId);
    }

    public function detail(int $userId, int $id): ?TaskDetail
    {
        return $this->tasks->findDetail($userId, $id);
    }

    public function create(
        int $userId,
        string $title,
        ?string $description,
        ?string $status,
        ?string $dueOn,
        AuditActor $actor,
    ): TaskDetail {
        return $this->tasks->create(
            $userId,
            $title,
            $description,
            $status ?? TaskStatus::NOT_STARTED,
            $dueOn,
            $actor,
        );
    }

    public function update(
        int $userId,
        int $id,
        string $title,
        ?string $description,
        ?string $status,
        ?string $dueOn,
        AuditActor $actor,
    ): ?TaskDetail {
        return $this->tasks->update($userId, $id, $title, $description, $status, $dueOn, $actor);
    }

    public function logicalDelete(int $userId, int $id, AuditActor $actor): bool
    {
        return $this->tasks->logicalDelete($userId, $id, $actor);
    }
}
