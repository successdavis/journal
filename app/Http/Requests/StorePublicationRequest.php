<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePublicationRequest extends FormRequest
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
            'abstract' => 'required|string',
            'keywords' => 'nullable|string',
            'article_type' => 'required|string',
            'affiliation' => 'nullable|string',
            'journal' => 'nullable|string',
            'category' => 'required|string',
            'reviewed_abstract' => 'required|string',
            'excerpt' => 'required|string',
            'main_document' => 'required|file|mimes:pdf,doc,docx',
            'figures.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'supplementary.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'ethical_approval' => 'nullable|string',
            'conflict_of_interest' => 'nullable|string',
            'funding_statement' => 'nullable|string',
            'consent' => 'required|boolean',
            'originality' => 'required|boolean',
            'views' =>'nullable|integer',
            'accepted_on' =>'nullable|String',
            'premium' => 'nullable|boolean',
            'amount'  => 'required_if:premium,true|numeric',
            'citation_information' => 'nullable|string',
            'co_writers' => 'nullable|string'
        ];
    }

}
