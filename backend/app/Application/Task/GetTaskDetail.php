<?php

declare(strict_types=1);

namespace App\Application\Task;

use App\Application\Task\Port\TaskRepository;
use App\Application\Task\ReadModel\TaskDetail;

final readonly class GetTaskDetail
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    public function handle(int $id): ?TaskDetail
    {
        return $this->tasks->findDetail($id);
    }
}
