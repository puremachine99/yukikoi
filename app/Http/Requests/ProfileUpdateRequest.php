<?php

namespace App\Http\Requests;

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
            'profile_photo' => ['nullable', 'image', 'mimes:png,jpg', 'max:2048'],
            'ktp_photo' => ['nullable', 'image', 'mimes:png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'farm_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15', 'unique:users,phone_number,' . $this->user()->id],
            'nik' => ['required', 'string', 'min:16', 'max:16', 'unique:users,nik,' . $this->user()->id],
            'is_seller' => ['nullable', 'boolean'],
        ];
    }
}
