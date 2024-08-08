<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [ 'required', 'string', 'email','max:255','unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed', 'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'],
            'role' => ['required', 'string'],
        ];
    }
}
