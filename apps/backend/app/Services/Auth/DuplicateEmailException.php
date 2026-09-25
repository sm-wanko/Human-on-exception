<?php

declare(strict_types=1);

namespace App\Services\Auth;

use RuntimeException;

/** 同じメールアドレスのアカウントが既にある */
final class DuplicateEmailException extends RuntimeException
{
}
