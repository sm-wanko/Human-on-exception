<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Services\Task\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Task の書き込み入力。登録日は受け取らない */
final class TaskWriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['sometimes', 'required', 'string', Rule::in(TaskStatus::VALUES)],
            'due_on' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        if (is_string($this->input('title'))) {
            $merge['title'] = trim($this->input('title'));
        }
        if ($this->input('due_on') === '') {
            $merge['due_on'] = null;
        }
        if (is_string($this->input('description')) && trim($this->input('description')) === '') {
            $merge['description'] = null;
        }
        if ($merge !== []) {
            $this->merge($merge);
        }
    }
}
