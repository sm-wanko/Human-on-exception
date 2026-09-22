<?php

declare(strict_types=1);

namespace App\Application\Task;

use App\Application\Task\Port\TaskRepository;
use App\Application\Task\ReadModel\TaskDetail;

final readonly class CreateTask
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    public function handle(string $title, ?string $description): TaskDetail
    {
        return $this->tasks->create($title, $description);
    }
}
