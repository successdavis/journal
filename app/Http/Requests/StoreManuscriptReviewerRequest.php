<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManuscriptReviewerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'manuscript_id'   => ['required', 'integer', 'exists:authors,id'],
            'reviewer_id'     => ['required', 'integer', 'exists:users,id'],
            'request_status'  => ['required', 'string', 'in:pending,accepted,rejected'],
            'complete_reviewed_on'     => ['nullable', 'date'],
            'status'          => ['required', 'string', 'in:in_progress,completed,declined'],
        ];
    }
}
