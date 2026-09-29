<?php

declare(strict_types=1);

namespace Tests\System;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AuthLoginSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_AUTH_LOGIN_SYS_001_register_then_session_shows_display_name(): void
    {
        $this->postJson('/api/auth/register', [
            'email' => '  Hanako@Example.com  ',
            'password' => 'password12',
            'display_name' => '  花子  ',
        ])->assertCreated()->assertJsonPath('display_name', '花子');

        $this->getJson('/api/auth/session')
            ->assertOk()
            ->assertJsonPath('display_name', '花子');

        $this->assertDatabaseHas('users', ['email' => 'hanako@example.com', 'display_name' => '花子']);
    }

    public function test_AUTH_LOGIN_SYS_002_duplicate_email_is_rejected(): void
    {
        $this->postJson('/api/auth/register', $this->account())->assertCreated();

        $this->postJson('/api/auth/register', [
            'email' => 'HANAKO@example.com',
            'password' => 'anotherpass',
            'display_name' => '別人',
        ])->assertUnprocessable()->assertJsonPath('message', 'Email is already registered');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_AUTH_LOGIN_SYS_003_unknown_email_and_wrong_password_match(): void
    {
        $this->postJson('/api/auth/register', $this->account())->assertCreated();

        $unknown = $this->postJson('/api/auth/login', [
            'email' => 'missing@example.com',
            'password' => 'password12',
        ]);
        $wrong = $this->postJson('/api/auth/login', [
            'email' => 'hanako@example.com',
            'password' => 'not-the-password',
        ]);

        $unknown->assertUnauthorized();
        $wrong->assertUnauthorized();
        $this->assertSame($unknown->json(), $wrong->json());
        $this->assertSame('Invalid credentials', $unknown->json('message'));
    }

    public function test_AUTH_LOGIN_SYS_004_logout_hides_display_name(): void
    {
        $this->postJson('/api/auth/register', $this->account())->assertCreated();
        $this->postJson('/api/auth/logout')->assertNoContent();

        $this->getJson('/api/auth/session')->assertUnauthorized();
    }

    /** @return array{email:string,password:string,display_name:string} */
    private function account(): array
    {
        return [
            'email' => 'hanako@example.com',
            'password' => 'password12',
            'display_name' => '花子',
        ];
    }
}
