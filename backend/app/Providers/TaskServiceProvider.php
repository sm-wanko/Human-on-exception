<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Task\Port\TaskRepository;
use App\Infrastructure\Persistence\EloquentTaskRepository;
use Illuminate\Support\ServiceProvider;

final class TaskServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepository::class, EloquentTaskRepository::class);
    }
}
