<?php

declare(strict_types=1);

namespace App\Application\Task;

use App\Application\Task\Port\TaskRepository;

final readonly class DeleteTask
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    public function handle(int $id): bool
    {
        return $this->tasks->delete($id);
    }
}
