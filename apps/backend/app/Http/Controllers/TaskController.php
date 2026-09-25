<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskWriteRequest;
use App\Services\Task\TaskService;
use App\Support\Audit\AuditActor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** ログイン中の本人の Task */
final class TaskController
{
    public function __construct(private readonly TaskService $tasks)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(array_map(
            static fn ($task) => $task->toArray(),
            $this->tasks->list($this->userId($request)),
        ));
    }

    public function show(Request $request, int $task): JsonResponse
    {
        $detail = $this->tasks->detail($this->userId($request), $task);

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function store(TaskWriteRequest $request): JsonResponse
    {
        $detail = $this->tasks->create(
            userId: $this->userId($request),
            title: $request->string('title')->toString(),
            description: $request->input('description'),
            status: $request->input('status'),
            dueOn: $request->input('due_on'),
            actor: $this->actor($request),
        );

        return response()->json($detail->toArray(), 201);
    }

    public function update(int $task, TaskWriteRequest $request): JsonResponse
    {
        $detail = $this->tasks->update(
            userId: $this->userId($request),
            id: $task,
            title: $request->string('title')->toString(),
            description: $request->input('description'),
            status: $request->exists('status') ? $request->string('status')->toString() : null,
            dueOn: $request->input('due_on'),
            actor: $this->actor($request),
        );

        return $detail === null
            ? response()->json(['message' => 'Not Found'], 404)
            : response()->json($detail->toArray());
    }

    public function destroy(Request $request, int $task): JsonResponse
    {
        return $this->tasks->logicalDelete($this->userId($request), $task, $this->actor($request))
            ? response()->json(null, 204)
            : response()->json(['message' => 'Not Found'], 404);
    }

    private function userId(Request $request): int
    {
        return (int) $request->user()->id;
    }

    private function actor(Request $request): AuditActor
    {
        return new AuditActor($this->userId($request));
    }
}
