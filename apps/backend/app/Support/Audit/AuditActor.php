<?php

declare(strict_types=1);

namespace App\Support\Audit;

/** 会員向け書き込みの操作者と経路 */
final readonly class AuditActor
{
    public const APP = 'member-ui';

    public function __construct(public int $userId)
    {
    }
}
