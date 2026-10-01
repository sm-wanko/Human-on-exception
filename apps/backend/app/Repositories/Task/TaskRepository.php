<?php

declare(strict_types=1);

namespace App\Repositories\Task;

use App\DTO\Task\TaskDetail;
use App\DTO\Task\TaskQuick;
use App\Models\Task;

final class TaskRepository
{
    /** @return list<TaskQuick> */
    public function listQuick(): array
    {
        return Task::query()
            ->select(['id', 'title'])
            ->orderBy('id')
            ->get()
            ->map(fn (Task $task) => new TaskQuick($task->id, $task->title))
            ->all();
    }

    public function findDetail(int $id): ?TaskDetail
    {
        $task = Task::query()->find($id);

        return $task === null ? null : $this->toDetail($task);
    }

    public function create(string $title, ?string $description): TaskDetail
    {
        $task = Task::query()->create([
            'title' => $title,
            'description' => $description,
        ]);

        return $this->toDetail($task);
    }

    public function update(int $id, string $title, ?string $description): ?TaskDetail
    {
        $task = Task::query()->find($id);
        if ($task === null) {
            return null;
        }

        $task->fill([
            'title' => $title,
            'description' => $description,
        ])->save();

        return $this->toDetail($task->refresh());
    }

    public function delete(int $id): bool
    {
        return Task::query()->whereKey($id)->delete() === 1;
    }

    private function toDetail(Task $task): TaskDetail
    {
        return new TaskDetail(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            createdAt: $task->created_at->toISOString(),
            updatedAt: $task->updated_at?->toISOString(),
        );
    }
}
