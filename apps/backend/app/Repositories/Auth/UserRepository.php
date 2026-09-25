<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

use App\Models\User;

/** アカウントの永続化 */
final class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function create(string $email, string $passwordHash, string $displayName): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => $passwordHash,
            'display_name' => $displayName,
        ]);
    }
}
