<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Application\Task\Port\TaskRepository;
use App\Application\Task\ReadModel\TaskDetail;
use App\Application\Task\ReadModel\TaskQuick;
use App\Models\Task;

final class EloquentTaskRepository implements TaskRepository
{
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

        return $task ? $this->detail($task) : null;
    }

    public function create(string $title, ?string $description): TaskDetail
    {
        $task = Task::query()->create([
            'title' => $title,
            'description' => $description,
        ]);

        return $this->detail($task);
    }

    public function update(int $id, string $title, ?string $description): ?TaskDetail
    {
        $task = Task::query()->find($id);
        if ($task === null) {
            return null;
        }

        $task->fill(['title' => $title, 'description' => $description])->save();

        return $this->detail($task->refresh());
    }

    public function delete(int $id): bool
    {
        return Task::query()->whereKey($id)->delete() === 1;
    }

    private function detail(Task $task): TaskDetail
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
