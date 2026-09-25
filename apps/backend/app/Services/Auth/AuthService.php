<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\UserRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Hash;

/** 本人登録とログイン判定 */
final readonly class AuthService
{
    /** 実在しないメールでも照合時間を揃えるためのダミーハッシュ */
    private const INVALID_PASSWORD_HASH = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

    public function __construct(private UserRepository $users)
    {
    }

    public function register(string $email, string $password, string $displayName): User
    {
        $email = self::normalizeEmail($email);
        if ($this->users->findByEmail($email) !== null) {
            throw new DuplicateEmailException();
        }

        try {
            return $this->users->create($email, Hash::make($password), $displayName);
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateEmailException();
        }
    }

    public function attempt(string $email, string $password): ?User
    {
        $user = $this->users->findByEmail(self::normalizeEmail($email));
        $hash = $user->password ?? self::INVALID_PASSWORD_HASH;
        if ($user === null || ! Hash::check($password, $hash)) {
            return null;
        }

        return $user;
    }

    public static function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
}
