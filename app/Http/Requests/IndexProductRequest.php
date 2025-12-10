<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => 'string|max:255',
            'sort' => 'in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'q.max' => 'Search term must not exceed 255 characters.',
            'sort.in' => 'Sort order must be either asc or desc.',
        ];
    }

    public function getSearch(): ?string
    {
        return $this->input('q');
    }

    public function getSortOrder(): string
    {
        return $this->input('sort', 'desc');
    }
}
