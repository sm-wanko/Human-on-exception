<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Task\CreateTask;
use App\Application\Task\DeleteTask;
use App\Application\Task\GetTaskDetail;
use App\Application\Task\ListTasks;
use App\Application\Task\UpdateTask;
use App\Http\Requests\TaskWriteRequest;
use Illuminate\Http\JsonResponse;

final class TaskController
{
    public function index(ListTasks $useCase): JsonResponse
    {
        return response()->json(array_map(
            static fn ($task) => $task->toArray(),
            $useCase->handle(),
        ));
    }

    public function show(int $task, GetTaskDetail $useCase): JsonResponse
    {
        $detail = $useCase->handle($task);

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function store(TaskWriteRequest $request, CreateTask $useCase): JsonResponse
    {
        $detail = $useCase->handle(
            title: $request->string('title')->toString(),
            description: $request->input('description'),
        );

        return response()->json($detail->toArray(), 201);
    }

    public function update(int $task, TaskWriteRequest $request, UpdateTask $useCase): JsonResponse
    {
        $detail = $useCase->handle(
            id: $task,
            title: $request->string('title')->toString(),
            description: $request->input('description'),
        );

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function destroy(int $task, DeleteTask $useCase): JsonResponse
    {
        return $useCase->handle($task)
            ? response()->json(null, 204)
            : response()->json(['message' => 'Not Found'], 404);
    }
}
