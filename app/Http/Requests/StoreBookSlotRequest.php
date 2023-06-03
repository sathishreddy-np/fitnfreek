<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookSlotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:55',
            'age' => 'required|integer',
            'gender' => 'required|string|max:55',
            'sport' => 'required|string|max:55',
            'slot_type' => 'required|string|max:55',
            'slot_name' => 'required|string|max:55',
            'starts_at_unix' => 'required|integer',
            'ends_at_unix' => 'required|integer',
            'starts_at_hours' => 'required|integer',
            'starts_at_minutes' => 'required|integer',
            'ends_at_hours' => 'required|integer',
            'ends_at_minutes' => 'required|integer',
            'amount' => 'required|numeric',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
