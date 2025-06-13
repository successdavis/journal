<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmittedReviewRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'review_is_honest' => filter_var($this->review_is_honest, FILTER_VALIDATE_BOOLEAN),
            'agreed_review_policy' => filter_var($this->agreed_review_policy, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'review_manuscript_id' => ['required', 'exists:manuscript_reviewers,id'],
            'review_title' => ['required', 'string'],
            'opinion' => ['required', 'string'],
            'general_comment' => ['required', 'string'],
            'specific_comment' => ['required', 'string'],
            'comment_to_editor' => ['required', 'string'],
            'originality' => ['required', 'integer', 'min:1', 'max:5'],
            'clarity_of_writing' => ['required', 'integer', 'min:1', 'max:5'],
            'methodology_soundness' => ['required', 'integer', 'min:1', 'max:5'],
            'relevance_of_manuscript' => ['required', 'integer', 'min:1', 'max:5'],
            'quality_of_data' => ['required', 'integer', 'min:1', 'max:5'],
            'annotated_manuscript' => ['required','file', 'mimes:pdf,doc,docx'],
            'supplementary_feedback' => ['nullable','file', 'mimes:pdf, doc,docx'],
            'conflict_of_interest' => ['required', 'string'],
            'submit_option' => ['required', 'in:draft,submitted'],
            'review_is_honest' => ['required', 'boolean'],
            'agreed_review_policy' => ['required', 'boolean'],
        ];
    }
}
