<?php

namespace App\Http\Requests\Frontend;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:60'],
            'email' => ['required', 'email', 'unique:users,email,'.auth()->user()->id]
        ];
    }
}
