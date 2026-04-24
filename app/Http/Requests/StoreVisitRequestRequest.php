<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'people_count' => ['required', 'integer', 'min:1', 'max:20'],
            'planned_visit_date' => ['nullable', 'date', 'after:today'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'Zadejte prosím své jméno.',
            'email.required' => 'Zadejte prosím e-mail.',
            'email.email' => 'E-mail není ve správném formátu.',
            'people_count.required' => 'Zadejte počet lidí.',
        ];
    }
}
