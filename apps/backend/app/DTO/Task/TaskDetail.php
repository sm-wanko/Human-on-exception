<?php

declare(strict_types=1);

namespace App\DTO\Task;

/** 詳細に出す Task */
final readonly class TaskDetail
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public string $status,
        public ?string $dueOn,
        public string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @return array{id:int,title:string,description:?string,status:string,due_on:?string,created_at:string,updated_at:?string} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'due_on' => $this->dueOn,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
