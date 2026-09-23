<?php

declare(strict_types=1);

namespace Tests\System;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TaskCrudSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_TASK_CRUD_SYS_001_create_then_list(): void
    {
        $this->postJson('/api/tasks', [
            'title' => '  Buy milk  ',
            'description' => '2L',
        ])->assertCreated()->assertJsonPath('title', 'Buy milk');

        $this->getJson('/api/tasks')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonMissingPath('0.description');

        $this->assertDatabaseHas('tasks', ['title' => 'Buy milk']);
    }

    public function test_TASK_CRUD_SYS_002_detail(): void
    {
        $id = $this->postJson('/api/tasks', [
            'title' => 'Buy milk',
            'description' => '2L',
        ])->json('id');

        $this->getJson("/api/tasks/{$id}")
            ->assertOk()
            ->assertJsonPath('description', '2L');
    }

    public function test_TASK_CRUD_SYS_003_update(): void
    {
        $id = $this->postJson('/api/tasks', ['title' => 'Old'])->json('id');

        $this->patchJson("/api/tasks/{$id}", ['title' => 'New'])
            ->assertOk()
            ->assertJsonPath('title', 'New');

        $this->assertDatabaseHas('tasks', ['id' => $id, 'title' => 'New']);
    }

    public function test_TASK_CRUD_SYS_004_delete(): void
    {
        $id = $this->postJson('/api/tasks', ['title' => 'Delete me'])->json('id');

        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $id]);
    }

    public function test_TASK_CRUD_SYS_101_blank_title(): void
    {
        $this->postJson('/api/tasks', ['title' => '   '])->assertUnprocessable();
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_TASK_CRUD_SYS_102_unknown_id(): void
    {
        $this->getJson('/api/tasks/999')->assertNotFound();
        $this->assertDatabaseCount('tasks', 0);
    }
}
