<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManuscriptRequest extends FormRequest
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
            'author_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'excerpt' => ['required', 'string'],
            'keywords' => ['nullable', 'string'],
            'affiliation' => ['nullable', 'string'],
            'journal' => ['nullable', 'string'],
            'main_document' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // max 10MB
            'figures' => ['nullable', 'array'],
            'figures.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // max 5MB each
            'supplementary' => ['nullable', 'array'],
            'supplementary.*' => ['file', 'mimes:pdf,zip', 'max:10240'], // max 10MB each
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'ethical_approval' => ['nullable', 'string'],
            'conflict_of_interest' => ['nullable', 'string'],
            'funding_statement' => ['nullable', 'string'],
            'consent' => ['required', 'boolean'],
            'originality' => ['required', 'boolean'],
            'status' => ['nullable', 'in:under_review,published,rejected,accepted'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'premium' => ['boolean'],
            'citation_information' => ['nullable', 'string'],
            'co_writers' => ['nullable', 'string'],
            'publication_type_id' => ['required', 'exists:publication_types,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
