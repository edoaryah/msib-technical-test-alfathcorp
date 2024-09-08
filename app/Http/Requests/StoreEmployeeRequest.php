<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'unique:employees,name',
            ],
            'salary' => [
                'required',
                'integer',
                'min:2000000',
                'max:10000000',
            ],
        ];
    }

    /**
     * Dapatkan pesan kesalahan kustom untuk aturan validasi.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 2 characters long.',
            'name.unique' => 'The name has already been taken.',
            'salary.required' => 'The salary field is required.',
            'salary.integer' => 'The salary must be an integer.',
            'salary.min' => 'The salary must be at least 2 million.',
            'salary.max' => 'The salary may not be greater than 10 million.',
        ];
    }
}
