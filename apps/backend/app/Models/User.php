<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/** メールアドレスで識別する本人のアカウント */
final class User extends Authenticatable
{
    /** @var list<string> */
    protected $fillable = ['email', 'password', 'display_name'];

    /** @var list<string> */
    protected $hidden = ['password'];
}
