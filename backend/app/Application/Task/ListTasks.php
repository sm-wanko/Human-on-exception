<?php

declare(strict_types=1);

namespace App\Application\Task;

use App\Application\Task\Port\TaskRepository;
use App\Application\Task\ReadModel\TaskQuick;

final readonly class ListTasks
{
    public function __construct(private TaskRepository $tasks)
    {
    }

    /** @return list<TaskQuick> */
    public function handle(): array
    {
        return $this->tasks->listQuick();
    }
}
