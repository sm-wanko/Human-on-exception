<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskWriteRequest;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;

final class TaskController
{
    public function __construct(private readonly TaskService $tasks)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(array_map(
            static fn ($task) => $task->toArray(),
            $this->tasks->list(),
        ));
    }

    public function show(int $task): JsonResponse
    {
        $detail = $this->tasks->detail($task);

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function store(TaskWriteRequest $request): JsonResponse
    {
        $detail = $this->tasks->create(
            title: $request->string('title')->toString(),
            description: $request->input('description'),
        );

        return response()->json($detail->toArray(), 201);
    }

    public function update(int $task, TaskWriteRequest $request): JsonResponse
    {
        $detail = $this->tasks->update(
            id: $task,
            title: $request->string('title')->toString(),
            description: $request->input('description'),
        );

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function destroy(int $task): JsonResponse
    {
        return $this->tasks->delete($task)
            ? response()->json(null, 204)
            : response()->json(['message' => 'Not Found'], 404);
    }
}
