<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'key' => ['required', Rule::in(['overtime_method'])],
            'value' => ['required', Rule::exists('references', 'id')->where(function ($query) {
                $query->where('code', 'like', 'overtime_method%');
            })],
        ];
    }

    public function authorize()
    {
        return true; // Izinkan semua pengguna untuk mengakses ini
    }
}
