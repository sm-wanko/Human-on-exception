<?php

declare(strict_types=1);

namespace App\Repositories\Task;

use App\DTO\Task\TaskDetail;
use App\DTO\Task\TaskQuick;
use App\Models\Task;
use App\Services\Task\TaskStatus;
use App\Support\Audit\AuditActor;

/** 本人の Task だけを読み書きする */
final class TaskRepository
{
    /** @return list<TaskQuick> */
    public function listQuick(int $userId): array
    {
        return Task::query()
            ->select(['id', 'title', 'status', 'due_on'])
            ->where('user_id', $userId)
            ->orderBy('id')
            ->get()
            ->map(fn (Task $task) => new TaskQuick(
                $task->id,
                $task->title,
                $task->status,
                $this->dueOn($task),
            ))
            ->all();
    }

    public function findDetail(int $userId, int $id): ?TaskDetail
    {
        $task = $this->owned($userId, $id);

        return $task === null ? null : $this->toDetail($task);
    }

    public function create(
        int $userId,
        string $title,
        ?string $description,
        string $status,
        ?string $dueOn,
        AuditActor $actor,
    ): TaskDetail {
        $task = Task::query()->create([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'due_on' => $dueOn,
            'created_by' => $actor->userId,
            'created_app' => AuditActor::APP,
            'updated_by' => $actor->userId,
            'updated_app' => AuditActor::APP,
        ]);

        return $this->toDetail($task);
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
        $task = $this->owned($userId, $id);
        if ($task === null) {
            return null;
        }

        $task->fill([
            'title' => $title,
            'description' => $description,
            'status' => $status ?? $task->status,
            'due_on' => $dueOn,
            'updated_by' => $actor->userId,
            'updated_app' => AuditActor::APP,
        ])->save();

        return $this->toDetail($task->refresh());
    }

    public function logicalDelete(int $userId, int $id, AuditActor $actor): bool
    {
        $task = $this->owned($userId, $id);
        if ($task === null) {
            return false;
        }

        $task->fill([
            'updated_by' => $actor->userId,
            'updated_app' => AuditActor::APP,
        ])->save();

        return (bool) $task->delete();
    }

    private function owned(int $userId, int $id): ?Task
    {
        return Task::query()->where('user_id', $userId)->whereKey($id)->first();
    }

    private function toDetail(Task $task): TaskDetail
    {
        return new TaskDetail(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: $task->status ?? TaskStatus::NOT_STARTED,
            dueOn: $this->dueOn($task),
            createdAt: $task->created_at->toISOString(),
            updatedAt: $task->updated_at?->toISOString(),
        );
    }

    private function dueOn(Task $task): ?string
    {
        return $task->due_on?->toDateString();
    }
}
