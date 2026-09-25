<?php

declare(strict_types=1);

namespace App\DTO\Task;

/** 一覧に出す Task */
final readonly class TaskQuick
{
    public function __construct(
        public int $id,
        public string $title,
        public string $status,
        public ?string $dueOn,
    ) {
    }

    /** @return array{id:int,title:string,status:string,due_on:?string} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'due_on' => $this->dueOn,
        ];
    }
}
