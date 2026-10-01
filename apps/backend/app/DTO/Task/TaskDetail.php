<?php

declare(strict_types=1);

namespace App\DTO\Task;

final readonly class TaskDetail
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @return array{id:int,title:string,description:?string,created_at:string,updated_at:?string} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
