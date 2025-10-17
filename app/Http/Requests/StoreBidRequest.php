<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'koi_id' => ['required', 'string', 'exists:kois,id'],
            'bid_amount' => ['required', 'numeric', 'min:1'],
        ];
    }
}
