<?php

declare(strict_types=1);

namespace App\Application\Task\Port;

use App\Application\Task\ReadModel\TaskDetail;
use App\Application\Task\ReadModel\TaskQuick;

interface TaskRepository
{
    /** @return list<TaskQuick> */
    public function listQuick(): array;

    public function findDetail(int $id): ?TaskDetail;

    public function create(string $title, ?string $description): TaskDetail;

    public function update(int $id, string $title, ?string $description): ?TaskDetail;

    public function delete(int $id): bool;
}
