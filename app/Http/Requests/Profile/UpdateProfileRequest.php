<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|max:2048',

            // Candidat Profile & Skills
            'title'  => 'nullable|string|max:255',
            'skills' => 'nullable|array',

            // Experience
            'exp_position'   => 'nullable|string|max:255',
            'exp_company'    => 'nullable|string|max:255',
            'exp_start_date' => 'nullable|date',
            'exp_end_date'   => 'nullable|date|after_or_equal:exp_start_date',

            // Education
            'edu_degree'     => 'nullable|string|max:255',
            'edu_school'     => 'nullable|string|max:255',
            'edu_year_start' => 'nullable|integer|min:1900|max:' . date('Y'),
            'edu_year_end'   => 'nullable|integer|min:1900|max:2099',

            // Recruteur
            'company_name'        => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
        ];
    }
}
