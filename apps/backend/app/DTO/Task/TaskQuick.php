<?php

declare(strict_types=1);

namespace App\DTO\Task;

final readonly class TaskQuick
{
    public function __construct(
        public int $id,
        public string $title,
    ) {
    }

    /** @return array{id:int,title:string} */
    public function toArray(): array
    {
        return ['id' => $this->id, 'title' => $this->title];
    }
}
