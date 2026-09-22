<?php

declare(strict_types=1);

namespace App\Application\Task;

use App\Application\Task\Port\TaskRepository;
use App\Application\Task\ReadModel\TaskDetail;

final readonly class UpdateTask
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    public function handle(int $id, string $title, ?string $description): ?TaskDetail
    {
        return $this->tasks->update($id, $title, $description);
    }
}
