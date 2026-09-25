<?php

declare(strict_types=1);

namespace Tests\System;

use App\Models\Task;
use App\Models\User;
use App\Support\Audit\AuditActor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class TaskCrudSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_TASK_CRUD_SYS_001_create_then_list(): void
    {
        $this->register();

        $this->postJson('/api/tasks', [
            'title' => '  Buy milk  ',
            'description' => '2L',
        ])->assertCreated()
            ->assertJsonPath('title', 'Buy milk')
            ->assertJsonPath('status', 'not_started');

        $this->getJson('/api/tasks')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.status', 'not_started')
            ->assertJsonMissingPath('0.description');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Buy milk',
            'created_by' => $this->userId(),
            'created_app' => AuditActor::APP,
        ]);
    }

    public function test_TASK_CRUD_SYS_002_detail(): void
    {
        $this->register();
        $id = $this->postJson('/api/tasks', [
            'title' => 'Buy milk',
            'description' => '2L',
        ])->json('id');

        $this->getJson("/api/tasks/{$id}")
            ->assertOk()
            ->assertJsonPath('description', '2L')
            ->assertJsonPath('status', 'not_started');
    }

    public function test_TASK_CRUD_SYS_003_update(): void
    {
        $this->register();
        $id = $this->postJson('/api/tasks', ['title' => 'Old'])->json('id');

        $this->patchJson("/api/tasks/{$id}", [
            'title' => 'New',
            'status' => 'in_progress',
        ])->assertOk()->assertJsonPath('title', 'New')->assertJsonPath('status', 'in_progress');

        $this->assertDatabaseHas('tasks', ['id' => $id, 'title' => 'New', 'status' => 'in_progress']);
    }

    public function test_TASK_CRUD_SYS_004_logical_delete_keeps_the_row(): void
    {
        $this->register();
        $id = $this->postJson('/api/tasks', ['title' => 'Delete me'])->json('id');

        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();

        $this->assertNotNull(Task::withTrashed()->find($id)?->deleted_at);
        $this->getJson("/api/tasks/{$id}")->assertNotFound();
        $this->getJson('/api/tasks')->assertOk()->assertJsonCount(0);
    }

    public function test_TASK_CRUD_SYS_005_guest_cannot_write(): void
    {
        $this->getJson('/api/tasks')->assertUnauthorized();
        $this->postJson('/api/tasks', ['title' => 'Hidden'])->assertUnauthorized();
        $this->patchJson('/api/tasks/1', ['title' => 'Hidden'])->assertUnauthorized();
        $this->deleteJson('/api/tasks/1')->assertUnauthorized();
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_TASK_CRUD_SYS_006_other_owner_is_not_found(): void
    {
        $this->register('hanako@example.com');
        $id = $this->postJson('/api/tasks', ['title' => 'Mine'])->json('id');
        $this->postJson('/api/auth/logout')->assertNoContent();
        $this->register('taro@example.com', '太郎');

        $this->getJson("/api/tasks/{$id}")->assertNotFound();
        $this->patchJson("/api/tasks/{$id}", ['title' => 'Stolen'])->assertNotFound();
        $this->deleteJson("/api/tasks/{$id}")->assertNotFound();
        $this->getJson('/api/tasks/999')->assertNotFound();

        $this->assertDatabaseHas('tasks', ['id' => $id, 'title' => 'Mine', 'deleted_at' => null]);
    }

    public function test_TASK_CRUD_SYS_007_ownerless_row_stays_hidden(): void
    {
        $this->register();
        $id = DB::table('tasks')->insertGetId([
            'title' => 'Orphan',
            'status' => 'not_started',
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->getJson('/api/tasks')->assertOk()->assertJsonCount(0);
        $this->getJson("/api/tasks/{$id}")->assertNotFound();
        $this->assertDatabaseHas('tasks', ['id' => $id, 'title' => 'Orphan']);
    }

    public function test_TASK_CRUD_SYS_008_dates_do_not_change_status(): void
    {
        $this->register();

        $created = $this->postJson('/api/tasks', [
            'title' => 'Buy milk',
            'due_on' => '2000-01-01',
            'created_at' => '1999-01-01T00:00:00Z',
        ])->assertCreated();

        $created->assertJsonPath('status', 'not_started');
        $created->assertJsonPath('due_on', '2000-01-01');
        $this->assertStringStartsNotWith('1999-01-01', (string) $created->json('created_at'));

        $this->assertDatabaseHas('tasks', [
            'id' => $created->json('id'),
            'status' => 'not_started',
        ]);
    }

    public function test_TASK_CRUD_SYS_009_check_does_not_change_status(): void
    {
        $this->register();
        $id = $this->postJson('/api/tasks', [
            'title' => 'Buy milk',
            'status' => 'in_progress',
        ])->json('id');

        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();

        $row = Task::withTrashed()->find($id);
        $this->assertNotNull($row);
        $this->assertSame('in_progress', $row->status);
        $this->assertNotNull($row->deleted_at);
    }

    public function test_TASK_CRUD_SYS_010_audit_follows_the_actor(): void
    {
        $this->register();
        $userId = $this->userId();
        $id = $this->postJson('/api/tasks', ['title' => 'Buy milk'])->json('id');

        $this->patchJson("/api/tasks/{$id}", ['title' => 'Updated'])->assertOk();
        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();

        $row = Task::withTrashed()->find($id);
        $this->assertNotNull($row);
        $this->assertSame($userId, (int) $row->created_by);
        $this->assertSame(AuditActor::APP, $row->created_app);
        $this->assertSame($userId, (int) $row->updated_by);
        $this->assertSame(AuditActor::APP, $row->updated_app);
    }

    public function test_TASK_CRUD_SYS_101_blank_title(): void
    {
        $this->register();
        $this->postJson('/api/tasks', ['title' => '   '])->assertUnprocessable();
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_TASK_CRUD_SYS_102_unknown_id(): void
    {
        $this->register();
        $this->getJson('/api/tasks/999')->assertNotFound();
        $this->assertDatabaseCount('tasks', 0);
    }

    private function register(string $email = 'hanako@example.com', string $name = '花子'): void
    {
        $this->postJson('/api/auth/register', [
            'email' => $email,
            'password' => 'password12',
            'display_name' => $name,
        ])->assertCreated();
    }

    private function userId(): int
    {
        return (int) User::query()->where('email', 'hanako@example.com')->value('id');
    }
}
