<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEditorDecisionRequest extends FormRequest
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
            'manuscript_id' => 'required|exists:authors,id',
            'submitted_review_id' => 'required|exists:submitted_reviews,id',
            'round' => 'required|integer|min:1',
            'decision' => 'required|string|in:accept,minor_revisions,major_revisions,reject,request_additional_review,resubmit_elsewhere,withdrawn_by_author',
            'comments_to_author' => 'nullable|string',
            'comments_to_reviewer' => 'nullable|string',
        ];
    }
}
