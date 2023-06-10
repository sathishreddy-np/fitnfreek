<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSlotRequest extends FormRequest
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
            'slots' => 'required|array',
            'slots.*.day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'slots.*.sport' => 'required|in:Swimming,Gym,Cricket,Badminton,Tennis',
            'slots.*.slot_type' => 'required|in:One-time,Subscription',
            'slots.*.slot_name' => 'required|min:3|max:55',
            'slots.*.no_of_slots' => 'required|numeric|min:0',
            'slots.*.starts_at_hours' => 'required|numeric|min:0|max:23',
            'slots.*.starts_at_minutes' => 'required|numeric|min:0|max:60',
            'slots.*.ends_at_hours' => 'required|numeric|min:0|max:23',
            'slots.*.ends_at_minutes' => 'required|numeric|min:0|max:60',
            'slots.*.slot_classifications.*.allowed_gender' => 'required',
            'slots.*.slot_classifications.*.allowed_age_from' => 'required|numeric|min:0|max:100',
            'slots.*.slot_classifications.*.allowed_age_to' => 'required|numeric|min:0|max:100',
            'slots.*.slot_classifications.*.amount' => 'required|numeric',
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
