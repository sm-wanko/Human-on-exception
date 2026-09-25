<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Services\Auth\AuthService;
use Illuminate\Foundation\Http\FormRequest;

/** 本人登録の入力 */
final class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
            'display_name' => ['required', 'string', 'max:80'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        if (is_string($this->input('email'))) {
            $merge['email'] = AuthService::normalizeEmail($this->input('email'));
        }
        if (is_string($this->input('display_name'))) {
            $merge['display_name'] = trim($this->input('display_name'));
        }
        if ($merge !== []) {
            $this->merge($merge);
        }
    }
}
