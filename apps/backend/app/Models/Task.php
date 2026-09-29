<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** 本人が持つ 1 件の Task */
final class Task extends Model
{
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'due_on',
        'created_by',
        'created_app',
        'updated_by',
        'updated_app',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'due_on' => 'date',
        ];
    }
}
