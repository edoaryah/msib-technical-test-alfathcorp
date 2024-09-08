<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreOvertimeRequest extends FormRequest
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
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],
            'date' => [
                'required',
                'date',
                Rule::unique('overtimes')->where(function ($query) {
                    return $query->where('employee_id', $this->employee_id);
                }),
            ],
            'time_started' => [
                'required',
                'date_format:H:i',
                'before:time_ended',
            ],
            'time_ended' => [
                'required',
                'date_format:H:i',
                'after:time_started',
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
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.integer' => 'The employee ID must be an integer.',
            'employee_id.exists' => 'The selected employee ID is invalid.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date is not a valid date.',
            'date.unique' => 'The employee has already registered overtime for this date.',
            'time_started.required' => 'The start time field is required.',
            'time_started.date_format' => 'The start time must be in the format HH:mm.',
            'time_started.before' => 'The start time must be before the end time.',
            'time_ended.required' => 'The end time field is required.',
            'time_ended.date_format' => 'The end time must be in the format HH:mm.',
            'time_ended.after' => 'The end time must be after the start time.',
        ];
    }
}
