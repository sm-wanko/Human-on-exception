<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_then_list(): void
    {
        // TASK_CRUD-SYS-001
        $this->postJson('/api/tasks', [
            'title' => '  Buy milk  ',
            'description' => '2L',
        ])->assertCreated()->assertJsonPath('title', 'Buy milk');

        $this->getJson('/api/tasks')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonMissingPath('0.description');
    }

    public function test_detail_uses_detail_projection(): void
    {
        // TASK_CRUD-SYS-002
        $id = $this->postJson('/api/tasks', [
            'title' => 'Buy milk',
            'description' => '2L',
        ])->json('id');

        $this->getJson("/api/tasks/{$id}")
            ->assertOk()
            ->assertJsonPath('description', '2L');
    }

    public function test_update(): void
    {
        // TASK_CRUD-SYS-003
        $id = $this->postJson('/api/tasks', ['title' => 'Old'])->json('id');

        $this->patchJson("/api/tasks/{$id}", ['title' => 'New'])
            ->assertOk()
            ->assertJsonPath('title', 'New');
    }

    public function test_delete(): void
    {
        // TASK_CRUD-SYS-004
        $id = $this->postJson('/api/tasks', ['title' => 'Delete me'])->json('id');

        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $id]);
    }

    public function test_blank_title_is_rejected(): void
    {
        // TASK_CRUD-SYS-101
        $this->postJson('/api/tasks', ['title' => '   '])->assertUnprocessable();
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_unknown_id_is_404(): void
    {
        // TASK_CRUD-SYS-102
        $this->getJson('/api/tasks/999')->assertNotFound();
    }
}
