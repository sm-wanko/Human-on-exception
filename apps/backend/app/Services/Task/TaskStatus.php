<?php

declare(strict_types=1);

namespace App\Services\Task;

/** Task の STATUS。表示ラベルとは別の保存値 */
final class TaskStatus
{
    public const NOT_STARTED = 'not_started';

    public const IN_PROGRESS = 'in_progress';

    public const DONE = 'done';

    /** @var list<string> */
    public const VALUES = [
        self::NOT_STARTED,
        self::IN_PROGRESS,
        self::DONE,
    ];
}
