<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CreateProjectValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'estimated_time' => 'required|integer',
            // 'created_by' => 'required|exists:users,id',
            // 'assigned_to' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title field must be at most 255 characters long.',

            'description.required' => 'The description field is required.',

            'start_datetime.required' => 'The start date and time field is required.',
            'start_datetime.date_time' => 'The start date and time field must be a valid date and time.',

            'end_datetime.required' => 'The end date and time field is required.',
            'end_datetime.date_time' => 'The end date and time field must be a valid date and time.',
            'end_datetime.after' => 'The end date and time must be after the start date and time.',

            'estimated_time.required' => 'The estimated time field is required.',
            'estimated_time.integer' => 'The estimated time field must be an integer.',

            // 'created_by.required' => 'The created by field is required.',
            // 'created_by.exists' => 'The created by user must exist.',

            // 'assigned_to.required' => 'The assigned to field is required.',
            // 'assigned_to.exists' => 'The assigned to user must exist.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator  $validator)
    {
        return back()->withErrors($validator->errors())->withInput();
    }
}
