<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccreditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Mettere i dovuti controlli

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return[
            'customer_company' => ['required', 'max:255'],
            'customer_email' => ['required', 'email'],
            'customer_name' => ['required', 'max:127'],
            'customer_id' => ['required', 'alpha_dash', 'max:127'],
            'pin' => ['required', 'max:255'],
            'machine' => ['max:127'],
            'duration' => ['required', 'integer'],
            'language' => ['required', 'max:2'],
            'level' => ['required', 'integer', 'between:1,7'],
            'format' => ['max:127'],
            'display_type' => ['required', 'max:5'],
        ];
    }
}
